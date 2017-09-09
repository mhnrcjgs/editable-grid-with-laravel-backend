<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Log;
use Survey\Continent;
use Survey\Country;
use Survey\Demo;
use Survey\EditableGrid;

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@home']);

Route::get('data', function () {

    $grid = new EditableGrid();

    Log::debug('request : '.json_encode(request()->all()));

    /*
    *  Add columns. The first argument of addColumn is the name of the field in the databse.
    *  The second argument is the label that will be displayed in the header
    */
    $grid->addColumn('id', 'ID', 'integer', NULL, false);
    $grid->addColumn('name', 'Name', 'string');
    $grid->addColumn('firstname', 'Firstname', 'string');
    $grid->addColumn('age', 'Age', 'integer');
    $grid->addColumn('height', 'Height', 'float');
    /* The column id_country and id_continent will show a list of all available countries and continents. So, we select all rows from the tables */
    $grid->addColumn('id_continent', 'Continent', 'string', Continent::pluck('name', 'id')->toArray()); //' , fetch_pairs($mysqli,'SELECT id, name FROM continent'),true);
    $grid->addColumn('id_country', 'Country', 'string', Country::pluck('name', 'id')->toArray()); //, fetch_pairs($mysqli,'SELECT id, name FROM country'),true );
    $grid->addColumn('email', 'Email', 'email');
    $grid->addColumn('freelance', 'Freelance', 'boolean');
    $grid->addColumn('lastvisit', 'Lastvisit', 'date');
    $grid->addColumn('website', 'Website', 'string');
    $grid->addColumn('action', 'Action', 'html', NULL, false, 'id');

    $row_per_page = 20;

    $page = request('page');
    $filter = request('filter');
    $sort = request('sort');
    $is_asc_sort = request('asc');
    $sort_type = 'asc';
    $skip_to = ($page-1)*$row_per_page;

    $total_records_unfiltered = Demo::count();

    if ($is_asc_sort)
    {
        $sort_type = 'asc';
    } else {
        $sort_type = 'desc';
    }


    if ($filter)
    {
        if ($sort)
        {
            $result = Demo::where('name', 'like', '%'.$filter.'%')->skip($skip_to)->take($row_per_page)
                ->orderBy($sort, $sort_type)->get();
        } else {
            $result = Demo::where('name', 'like', '%'.$filter.'%')->skip($skip_to)->take($row_per_page)->get();
        }


        $total_records = Demo::where('name', 'like', '%'.$filter.'%')->count();
    }
    else
    {
        if ($sort) {
            $result = Demo::skip($skip_to)->take($row_per_page)
                ->orderBy($sort, $sort_type)->get();
        } else {
            $result = Demo::skip($skip_to)->take($row_per_page)->get();
        }

        $total_records = Demo::count();
    }


    $grid->setPaginator(ceil($total_records/$row_per_page), (int) $total_records, (int) $total_records_unfiltered, null);

    $grid->renderJSON($result,false, false, !isset($_GET['data_only']));

});
