<tr>
    <td>
        @if ($id > 0)
            <div class="form-inline">
                <label for="{{$id }}">
                    {!! Form::checkbox($id, 'yes', $val, ['class' => 'form-control '.$class]) !!} &nbsp; {{ $name }}
                </label>
            </div>
            @else
            &raquo; <a href="{{ route('admin.roles.pages', ['roleId' => '']) }}" id="page_permissions">{{ $name }}</a>
        @endif
    </td>
</tr>