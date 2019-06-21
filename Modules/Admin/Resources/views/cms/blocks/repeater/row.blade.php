<tr id="{!! $repeater_id !!}_{!! $row_id !!}">
    <td class="repeater-action" style="width: 40px; border: 0;">
        {!! Form::hidden('repeater['.$repeater_id.']['.$row_id.'][0]', 1) !!}
        <i class="glyphicon glyphicon-move"></i>
    </td>
    <td style="padding: 0px;">
        @php
            $id = $repeater_id.'-'.$row_id;
        @endphp
        <div id="accordion-{{ $id }}" class="accordion" role="panel-group">
            <div class="panel panel-primary" style="border: 0;">
                <div class="panel-heading" role="tab">
                    <h4 class="panel-title">
                        <a href="#repeater-row-{{ $id }}" data-parent="#accordion-{{ $id }}" data-toggle="collapse"
                            class="accordion-toggle @if ($index > 1) collapsed @endif">
                            {{ $index.'.- '.$label }}
                        </a>
                    </h4>
                </div>
                <div id="repeater-row-{{ $id }}" class="panel-collapse collapse @if ($index == 1 || $index == 'New') in @endif"
                    role="tabpanel" data-parent="#accordion-{{ $id }}" style="padding: 12px; border: 1px solid #ddd;
                    border-bottom-left-radius: 5px; border-bottom-right-radius: 5px">
                    {!! $blocks !!}
                </div>
            </div>
        </div>
    </td>
    <td class="repeater-action" style="width: 40px; border: 0;">
        <i class="glyphicon glyphicon-remove itemTooltip"
           onclick="repeater_delete({!! $repeater_id !!}, {!! $row_id !!})"></i>
    </td>
</tr>
