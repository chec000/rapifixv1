{!! PageBuilder::section('head') !!}

<div class="jumbotron" style="background: url({{ PageBuilder::block('internal_banner', ['view' => 'raw']) }}) no-repeat center"></div>

<section id="sec1">
    <div class="container">

    
      
        <div class="row">

            <div class="col-sm-9">

                <h1>{!! PageBuilder::block('title') !!}</h1>
                <h2 class="sub-header">Posted on {{ PageBuilder::block('post_date', ['format' => 'jS F Y']) }} by {{ PageBuilder::block('post_author') }}</h2>
                <p class="lead">{!! PageBuilder::block('lead_text') !!}</p>
                {!! PageBuilder::block('content') !!}
                {!! PageBuilder::block('video') !!}


                {!! PageBuilder::block('comments') !!}
                {!! PageBuilder::block('comments', ['form' => true]) !!}

            </div>

            <div class="col-sm-3">
                {!! PageBuilder::section('blog-bar') !!}
            </div>

        </div>

    </div>
</section>

{!! PageBuilder::section('footer') !!}