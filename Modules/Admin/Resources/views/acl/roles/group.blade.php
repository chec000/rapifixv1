<div class="role_sections row">
    <div class="panel panel-primary border-violet">
        <!-- Default panel contents -->
        <div class="panel-heading-violet panel-heading collapse_tbl_group" data-toggle="collapse" data-target="#collapse_{!! $index_group !!}">
            <h4>
                <span class="white-grey-hover">{!! trans($group) !!}</span>
                <div class="pull-right">
                    <i class="glyphicon glyphicon-chevron-down glyphicon-white"></i>
                </div>
            </h4>
        </div>
        <div class="panel-body panel-collapse in" id="collapse_{!! $index_group !!}">
            <!-- Table -->
            {!! $sections !!}
        </div>
    </div>
</div>