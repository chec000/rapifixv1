<li class="nav-item {{ ($item->active)?' active':'' }}">
    <a href="{{ url($item->url) }}">{{ $item->name }}</a>
</li>