@extends('layouts.app')


@section('content')

    <div class="row">

        <div class="col-lg-12">

            <div id="wrap">

                <h3>Editable Table</h3>


                <div id="toolbar">
                    <input type="text" id="filter" name="filter" placeholder="Filter :type any text here" />
                    <a id="showaddformbutton" class="button green"><i class="fa fa-plus"></i>Add new row</a>
                </div>

                <div id="tablecontent"></div>

                <div id="paginator"></div>
            </div>

        </div>

        <script src="js/jquery-1.11.1.min.js" ></script>
        <script src="js/editablegrid-2.1.0-49.js"></script>
        <!-- EditableGrid test if jQuery UI is present. If present, a datepicker is automatically used for date type -->
        <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
        <script src="js/demo.js" ></script>

        <script type="text/javascript">

            var datagrid;

            window.onload = function() {


                datagrid = new DatabaseGrid();


                 //key typed in the filter field
                $("#filter").keyup(function() {
                    datagrid.editableGrid.filter( $(this).val());

                    // To filter on some columns, you can set an array of column index
                    datagrid.editableGrid.filter( $(this).val(), [0,3,5]);
                });


                $("#showaddformbutton").click( function()  {
                    showAddForm();
                });
                $("#cancelbutton").click( function() {
                    showAddForm();
                });
                $("#addbutton").click(function() {
                    datagrid.addRow();
                });

            };

            $(function () {
            });

        </script>


        <div id="addform">

            <div class="row">
                <input type="text" id="name" name="name" placeholder="name" />
            </div>

            <div class="row">
                <input type="text" id="firstname" name="firstname" placeholder="firstname" />
            </div>

            <div class="row tright">
                <a id="addbutton" class="button green" ><i class="fa fa-save"></i> Apply</a>
                <a id="cancelbutton" class="button delete">Cancel</a>
            </div>
        </div>

    </div>



@stop