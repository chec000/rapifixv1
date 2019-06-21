<stream id="cloudflare-slide-{{ $videoCloudFlare->extra_attrs['index'] }}" src="{{ $videoCloudFlare->id  }}"
    loop mute class="mainslider__video show" style="z-index: -1; position: absolute; width: 100%">
</stream>
<script data-cfasync="false" defer type="text/javascript"
    src="https://embed.cloudflarestream.com/embed/r4xu.fla9.latest.js?video={{ $videoCloudFlare->id }}">
</script>
