<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\Page */

$this->title = Yii::t('backend', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-tree">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=  \talma\widgets\JsTree::widget([
        'name' => 'jstree',
        'data' => new JsExpression(
            'function (obj, callback) {
                $.ajax("'.Url::toRoute(['j-tree', 'root'=>$model->id]).'", {
                    dataType:"json",
                    data: {id: obj.id},
                    success: function(data) {
                        callback.call(this, data);
                    }
                });
            }'),
        'plugins' => ['types', 'dnd', 'contextmenu', 'wholerow', 'state'],
        'checkbox' => [],
        'types' => [
            'page' => [
                'valid_children' => ['page'],
            ],
        ],
        'core' => [
            'check_callback' => true,
        ],
        'bind' => [
            //'create_node.jstree' => 'function(event, obj) {}',
            'delete_node.jstree' => 'function(event, obj) {
                    if (parseInt(obj.node.id)) {
                        $.ajax("'.Url::toRoute(['j-delete']).'",
                            {
                                data: {id:obj.node.id},
                            }
                        );
                    }
                }',
            'rename_node.jstree ' => 'function(event, obj) {
                    if (parseInt(obj.node.id)) {
                        $.ajax("'.Url::toRoute(['j-rename']).'",
                            {
                                data: {id:obj.node.id, name:obj.text},
                            }
                        );
                    }
                }',
            'move_node.jstree' => 'function(event, obj) {
                    $.ajax("'.Url::toRoute(['j-move']).'",
                        {
                            data: {id:obj.node.id, parent:obj.parent, position:obj.position, old_parent:obj.old_parent, old_position:obj.old_position},
                        }
                    );
                }',
        ],
        'contextmenu' => [
            'items' => new JsExpression('
function(node) {
    var items = $.jstree.defaults.contextmenu.items();
    delete items.ccp;
    var removeAction = items.remove.action;
    items.remove.action = function(event, obj) {
        if (confirm("'.Yii::t('backend', 'Are you sure?').'")) {
            removeAction.call(this, event, obj);
        }
    }
    var createAction = items.create.action;
    items.create.action = function(data) {
        var inst = $.jstree.reference(data.reference),
            obj = inst.get_node(data.reference);

        inst.create_node(obj, {"type":"page"}, "last", function (new_node) {
            new_node.a_attr.style = \'opacity:.5\';
            inst.edit(new_node, "",
                function(node) {
                    if (node.text) {
                        $.ajax("'.Url::toRoute(['j-create']).'",
                            {
                                data: {name:node.text, parent:node.parent},
                                dataType:"json",
                                success: function(data) {
                                    inst.set_id(node, data["id"]);
                                }
                            }
                        );
                    } else {
                        inst.delete_node(node);
                    }
                }
            );
        });
    }

    items.update = {
        label:"'.Yii::t('backend', 'Update').'",
        action: function(data) {
            var inst = $.jstree.reference(data.reference),
                obj = inst.get_node(data.reference);
            location.href=("'.Url::toRoute(['update', 'id'=>'ID', 'return'=>Url::current()]).'").replace("ID", obj.id);
        }
    };

    items.rename.label = "'.Yii::t('backend', 'Rename').'";
    items.create.label = "'.Yii::t('backend', 'Create').'";
    items.remove.label = "'.Yii::t('backend', 'Delete').'";

    items.show = {
        label:"'.Yii::t('backend', 'Show').'",
        action: function(data) {
            var inst = $.jstree.reference(data.reference),
                obj = inst.get_node(data.reference);

            $.ajax("'.Url::toRoute(['j-show']).'",
                {
                    data: {id:obj.id},
                    dataType:"json",
                    success: function() {
                        data.reference.css("opacity", "1");
                    }
                }
            );
        }
    };

    items.hide = {
        label:"'.Yii::t('backend', 'Hide').'",
        action: function(data) {
            var inst = $.jstree.reference(data.reference),
                obj = inst.get_node(data.reference);

            $.ajax("'.Url::toRoute(['j-hide']).'",
                {
                    data: {id:obj.id},
                    dataType:"json",
                    success: function() {
                        data.reference.css("opacity", ".5");
                    }
                }
            );
        }
    };

    items.go = {
        label:"'.Yii::t('backend', 'Go to page').'",
        action: function(data) {
            var inst = $.jstree.reference(data.reference),
                obj = inst.get_node(data.reference);

            location.replace(("'.Url::toRoute(['go', 'id'=>'ID']).'").replace("ID", obj.id));
        }
    };

    return items;
}'),
        ],
    ]); ?>
</div>
