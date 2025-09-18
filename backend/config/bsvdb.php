<?php

return [

    'users' => [
        [
            'id' => 1, 
            'email' => 'prova@gmail.com',
            'password' => '12345678',
            'user_role' => 'admin',
        ],
        [
            'id' => 2, 
            'email' => 'villasetaregna@gmail.com',
            'password' => '12345678',
            'user_role' => 'user',
        ],
        [
            'id' => 3, 
            'email' => 'vendoerba@gmail.com',
            'password' => '12345678',
            'user_role' => 'user',
        ],
        [
            'id' => 4, 
            'email' => 'partner@example.com',
            'password' => '12345678',
            'user_role' => 'partner',
        ],
    ],

    'tags' => [
        [
            'id' => 1, 
            'name' => 'Tech',
        ],
        [
            'id' => 2, 
            'name' => 'Art',
        ],
    
        [
            'id' => 3, 
            'name' => 'Science',
        ]
    ],
    
    'articles' => [
        [
            'id' => 1, 
            'title' => 'The Future of AI', 
            'subtitle' => 'Exploring GPT models', 
            'article' => 'Lorem ipsum AI...'
        ],

        [
            'id' => 2,
            'title' => 'Impressionism', 
            'subtitle' => 'A revolution in color', 
            'article' => 'The Impressionist movement...'
            ],
    ],
    
    'comments' => [
        [
            'id' => 1, 
            'comment' => 'Great read!',
            'like' => 10, 
            'article_id' => 1,
            'is_flagged' => false, 
            'predefinite_comment' => null,
            'user_id' => 1
        ],
        [
            'id' => 2,
            'comment' => null,
            'like' => 2,
            'article_id' => 1,
            'is_flagged' => false, 
            'predefinite_comment' => 'very good',
            'user_id' => 1
        ],
        [
            'id' => 3, 
            'comment' => 'Love this topic.', 
            'like' => 5, 
            'article_id' => 2, 
            'is_flagged' => true, 
            'predefinite_comment' => null,
            'user_id' => 1
        ],
    ],
    
    'sections' => [
        [
            'id' => 1, 
            'title' => 'Home'
        ],
        [
            'id' => 2, 
            'title' => 'About Us'
        ],
    ],
    

    'page_sections' => [
        [
            'id' => 1, 
            'type' => 'text', 
            'content' => 'Welcome to our homepage!', 
            'section_id' => 1
        ],
        [
            'id' => 2, 
            'type' => 'text', 
            'content' => 'We are passionate about knowledge.', 
            'section_id' => 2
        ],
    ],

    'images' => [
        [
            'id' => 1, 
            'name' => 'ai-cover.jpg', 
            'alt' => 'AI Article Cover', 
            'link' => '/img/ai-cover.jpg', 
            'article_id' => 1, 
            'page_section_id' => 1
        ],
        [
            'id' => 2, 
            'name' => 'about-us.jpg', 
            'alt' => 'Team Photo', 
            'link' => '/img/team.jpg', 
            'article_id' => null, 
            'page_section_id' => 2
        ],
    ],
    'flagged_comments'=> [
        [
            'id' => 1,
            'reason'=> 'ha offeso il mio cane',
            'user_id'=> 1,
            'comment_id' => 1,
        ],
        [
            'id'=> 2,
            'reason' => 'mi ha dato del secchione',
            'user_id' => 1,
            'comment_id' => 1,
        ],
        [
            'id'=> 3,
            'reason' => 'ha offeso tutta la mia famiglia',
            'user_id' => 2,
            'comment_id' => 3,
        ],
        [
            'id'=> 3,
            'reason' => 'mi ha chiamato cassone',
            'user_id' => 2,
            'comment_id' => 3,
        ],
    ]
];