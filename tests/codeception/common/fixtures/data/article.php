<?php
/**
 * @author Eugene Terentev <eugene@terentev.net>
 */
return [
    [
        'id' => 1,
        'slug' => 'test-article-1',
        'title' => 'Test Article 1',
        'body' => 'Lorem ipsum',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
        'published_at' => new \yii\db\Expression('NOW() - INTERVAL 1 hour'),
        'created_at' => new \yii\db\Expression('NOW()'),
        'updated_at' => new \yii\db\Expression('NOW()'),
        'language' => 'en-US',
    ],
    [
        'id' => 2,
        'slug' => 'test-article-2',
        'title' => 'Test Article 2',
        'body' => 'Lorem ipsum',
        'created_by' => 1,
        'updated_by' => 1,
        'status' => 1,
        'published_at' => new \yii\db\Expression('NOW() + INTERVAL 1 year'),
        'created_at' => new \yii\db\Expression('NOW() + INTERVAL 1 year'),
        'updated_at' => new \yii\db\Expression('NOW() + INTERVAL 1 year'),
        'language' => 'en-US',
    ]
];
