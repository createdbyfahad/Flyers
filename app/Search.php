<?php

namespace App;

use Es;
use Input;

class Search
{
    //
    public static function searchEngine()
    {
        $query = is_null(Input::get('q'))? ' ' : Input::get('q');
        $params = [
            'index' => 'flyers',
            'type' => 'posts',
            'body' => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'fuzzy_like_this' => [
                                'fields' => ['title', 'body'],
                                'like_text' => $query
                            ]
                        ]
                    ]
                ]
            ]
        ];
        //search filters
        //category
        if(Input::get('cat') && $category_id = Category::getIdByCode(Input::get('cat')))
        {
            $params['body']['query']['filtered']['filter']['term']['category_id'] = $category_id;
        }
        $search = Es::search($params);
        $collection = $search['hits']['hits'];
        return $collection;
    }

    public static function similarPosts($id)
    {
    	$params = [
            'index' => 'flyers',
            'type' => 'posts',
            'body' => [
                'query' => [
                	'more_like_this' => [
                		'fileds' => ['title', 'body'],
                		'ids' => [$id],
                		'min_term_freq' => 1,
                		'max_query_terms'	=> 12
                	]
                ]
            ]
        ];

        $search = Es::search($params);

        dd($search);
    }

}
