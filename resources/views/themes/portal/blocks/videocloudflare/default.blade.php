<stream src="{{ $videoCloudFlare->id }}" controls preload style="width: {{ $videoCloudFlare->extra_attrs['width'] }}">
</stream>
<script data-cfasync="false" defer type="text/javascript"
    src="https://embed.cloudflarestream.com/embed/r4xu.fla9.latest.js?video={{ $videoCloudFlare->id }}">
</script>
