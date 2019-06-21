<div class="col-sm-4">
    <div class="panel panel-info border-violet">
        <!-- Default panel contents -->
        <div class="panel-heading collapse_tbl_group panel-heading-violet" data-toggle="collapse" data-target="#collapse_{!! $index_tbl_options !!}">
            <span class="white-grey-hover"> {!! $section !!} </span>
            <div class="pull-right">
                <i class="glyphicon glyphicon-chevron-down glyphicon-white"></i>
            </div>
        </div>
        <div class="panel-body panel-collapse in" id="collapse_{!! $index_tbl_options !!}">
            <!-- Table -->
            <table class="table table-roles">
                <tbody>
                {!! $options !!}
                </tbody>
            </table>
        </div>
    </div>
</div>