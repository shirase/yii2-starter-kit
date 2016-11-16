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
        'published_at' => date('Y-m-d H:i:s', time() - 10),
        'created_at' => date('Y-m-d H:i:s', time() - 10),
        'updated_at' => date('Y-m-d H:i:s', time() - 10)
    ],
    [
        'id' => 2,
        'slug' => 'test-article-2',
        'title' => 'Test Article 2',
        'body' => 'Lorem ipsum',
        'created_by' => 1,
        'updated_by' => 1,
        'status' => 1,
        'published_at' => date('Y-m-d H:i:s', time() + \cheatsheet\Time::SECONDS_IN_A_YEAR),
        'created_at' => date('Y-m-d H:i:s', time() + \cheatsheet\Time::SECONDS_IN_A_YEAR),
        'updated_at' => date('Y-m-d H:i:s', time() + \cheatsheet\Time::SECONDS_IN_A_YEAR)
    ]
];
