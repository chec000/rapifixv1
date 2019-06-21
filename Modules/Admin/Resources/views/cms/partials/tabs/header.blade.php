@foreach ($tabs as $index => $name)

    <li id="navtab{!! $index !!}" class="take-all-space-you-can tab_background_violet {!! $index<0?' pull-right':'' !!}">
        <a href="{{ '#tab'.$index }}" data-toggle="tab" aria-expanded="true">{!! $name !!}</a>
    </li>

@endforeach
