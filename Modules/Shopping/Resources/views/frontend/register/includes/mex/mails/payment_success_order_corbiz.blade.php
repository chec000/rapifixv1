@php
	$footerLogo = asset('/uploads/images/mailing/logos/' . \App\Helpers\SessionHdl::getLocale() . '/omnilife_footer.png');
    $headerLogo = asset('/uploads/images/mailing/logos/' . \App\Helpers\SessionHdl::getLocale() . '/omnilife_header.png');
	$urlCREO    = \App\Helpers\CoasterFunctions::generatePageUrl(config('settings::inspire.creo.page_code'), config('settings::inspire.creo.page_template'));

	$finalUrlCREO = "<a href='{$urlCREO}' target='_blank'>CREO</a>";
@endphp

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<!-- If you delete this tag, the sky will fall on your head -->
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{!! trans('shopping::checkout.email.success_order.title') !!}</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="stylesheets/email.css" />
</head>
<style>
	/* -------------------------------------
            GLOBAL
    ------------------------------------- */
	* {
		margin:0;
		padding:0;
	}
	* { font-family: "Roboto", "Helvetica", Helvetica, Arial, sans-serif; }

	img {
		max-width: 100%;
	}
	.collapse {
		margin:0;
		padding:0;
	}
	body {
		-webkit-font-smoothing:antialiased;
		-webkit-text-size-adjust:none;
		width: 100%!important;
		height: 100%;
	}


	/* -------------------------------------
            ELEMENTS
    ------------------------------------- */
	a { color: #2BA6CB;}

	.btn {
		text-decoration:none;
		color: #FFF;
		background-color: #666;
		padding:10px 16px;
		font-weight:bold;
		margin-right:10px;
		text-align:center;
		cursor:pointer;
		display: inline-block;
	}

	p.callout {
		padding:15px;
		background-color:#ECF8FF;
		margin-bottom: 15px;
	}
	.callout a {
		font-weight:bold;
		color: #2BA6CB;
	}

	table.social {
		/* 	padding:15px; */
		background-color: #ebebeb;

	}
	.social .soc-btn {
		padding: 3px 7px;
		font-size:12px;
		margin-bottom:10px;
		text-decoration:none;
		color: #FFF;font-weight:bold;
		display:block;
		text-align:center;
	}
	a.fb { background-color: #3B5998!important; }
	a.tw { background-color: #1daced!important; }
	a.gp { background-color: #DB4A39!important; }
	a.ms { background-color: #000!important; }

	.sidebar .soc-btn {
		display:block;
		width:100%;
	}

	.cart__confirm-items {
		margin-top: 25px !important;
		margin-bottom: 25px !important;
	}
	.cart__confirm-item {
		display: -webkit-box;
		display: -moz-box;
		display: -webkit-flex;
		display: -ms-flexbox;
		display: box;
		display: flex;
		-webkit-box-align: center;
		-moz-box-align: center;
		-o-box-align: center;
		-ms-flex-align: center;
		-webkit-align-items: center;
		align-items: center;
		border-bottom: 1px solid rgba(0,0,0,0.1);
		padding: 0.25rem 0.25rem 0.25rem 1rem;
		text-align: left;
		min-width: 320px;
		font-size: 0.95rem;
	}
	.list-nostyle {
		padding-left: 0;
		margin: 0;
		list-style: none;
	}
	.cart__confirm-items.mul .cart__confirm-item__qty {
		width: 25px;
	}
	.cart__confirm-items.mul .cart__confirm-item__name {
		width: 148px;
	}
	.cart__confirm-item__name {
		width: 60%;
		padding-right: 0.5rem;
		white-space: nowrap;
		overflow: hidden;
		-o-text-overflow: ellipsis;
		text-overflow: ellipsis;
	}
	.cart__confirm-items.mul .cart__confirm-item__code {
		width: 63px;
	}
	.cart__confirm-items.mul .cart__confirm-item__price, .cart__confirm-items.mul .cart__confirm-item__pts {
		width: 44px;
	}
	.order-info {
		margin-bottom: 0;
		font-size: 0.90em;
		text-align: right;
		line-height: 1.3;
	}
	.order-info > span.total {
		font-size: 1.3em;
		font-weight: bold;
	}

	/* -------------------------------------
            HEADER
    ------------------------------------- */
	table.head-wrap { width: 100%;}

	.header.container table td.logo { padding: 15px; }
	.header.container table td.label { padding: 15px; padding-left:0px;}


	/* -------------------------------------
            BODY
    ------------------------------------- */
	table.body-wrap { width: 100%;}


	/* -------------------------------------
            FOOTER
    ------------------------------------- */
	table.footer-wrap { width: 100%;	clear:both!important;
	}
	.footer-wrap .container td.content  p { border-top: 1px solid rgb(215,215,215); padding-top:15px;}
	.footer-wrap .container td.content p {
		font-size:10px;
		font-weight: bold;

	}


	/* -------------------------------------
            TYPOGRAPHY
    ------------------------------------- */
	h1,h2,h3,h4,h5,h6 {
		font-family: "Roboto", "Helvetica Neue Light", "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; line-height: 1.1; margin-bottom:15px; color:#000;
	}

	h1 small, h2 small, h3 small, h4 small, h5 small, h6 small { font-size: 60%; color: #6f6f6f; line-height: 0; text-transform: none; }

	h1 { font-weight:200; font-size: 44px;}
	h2 { font-weight:200; font-size: 37px;}
	h3 { font-weight:500; font-size: 27px;}
	h4 { font-weight:500; font-size: 23px;}
	h5 { font-weight:900; font-size: 17px;}
	h6 { font-weight:900; font-size: 14px; text-transform: uppercase; color:#444;}

	.collapse { margin:0!important;}

	p, ul {
		margin-bottom: 10px;
		font-weight: normal;
		font-size:14px;
		line-height:1.6;
	}
	p.lead { font-size:17px; }
	p.last { margin-bottom:0px;}

	ul li {
		margin-left:5px;
		list-style-position: inside;
	}

	/* -------------------------------------
            SIDEBAR
    ------------------------------------- */
	ul.sidebar {
		background:#ebebeb;
		display:block;
		list-style-type: none;
	}
	ul.sidebar li { display: block; margin:0;}
	ul.sidebar li a {
		text-decoration:none;
		color: #666;
		padding:10px 16px;
		/* 	font-weight:bold; */
		margin-right:10px;
		/* 	text-align:center; */
		cursor:pointer;
		border-bottom: 1px solid #777777;
		border-top: 1px solid #FFFFFF;
		display:block;
		margin:0;
	}
	ul.sidebar li a.last { border-bottom-width:0px;}
	ul.sidebar li a h1,ul.sidebar li a h2,ul.sidebar li a h3,ul.sidebar li a h4,ul.sidebar li a h5,ul.sidebar li a h6,ul.sidebar li a p { margin-bottom:0!important;}



	/* ---------------------------------------------------
            RESPONSIVENESS
            Nuke it from orbit. It's the only way to be sure.
    ------------------------------------------------------ */

	/* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */
	.container {
		display:block!important;
		max-width:600px!important;
		margin:0 auto!important; /* makes it centered */
		clear:both!important;
	}

	/* This should also be a block element, so that it will fill 100% of the .container */
	.content {
		padding:15px;
		max-width:600px;
		margin:0 auto;
		display:block;
	}

	/* Let's make sure tables in the content area are 100% wide */
	.content table { width: 100%; }


	/* Odds and ends */
	.column {
		width: 300px;
		float:left;
	}
	.column tr td { padding: 15px; }
	.column-wrap {
		padding:0!important;
		margin:0 auto;
		max-width:600px!important;
	}
	.column table { width:100%;}
	.social .column {
		width: 280px;
		min-width: 279px;
		float:left;
	}

	.header.container img {
		width: 170px;
	}

	/* Be sure to place a .clear element after each set of columns, just to be safe */
	.clear { display: block; clear: both; }


	/* -------------------------------------------
            PHONE
            For clients that support media queries.
            Nothing fancy.
    -------------------------------------------- */
	@media  only screen and (max-width: 600px) {

		a[class="btn"] { display:block!important; margin-bottom:10px!important; background-image:none!important; margin-right:0!important;}

		div[class="column"] { width: auto!important; float:none!important;}

		table.social div[class="column"] {
			width:auto!important;
		}

	}
</style>
<body bgcolor="#e2e1e0">

<!-- HEADER -->
<table class="head-wrap" bgcolor="#690d81">
	<tr>
		<td></td>
		<td class="header container">
			<div class="content">
				<table >
					<tr>
						<td><img style="width: 170px;" src="{{ asset($headerLogo) }}" /></td>
						<td align="right"><h6 class="collapse" style="color:#FFFFFF">{!! trans('shopping::checkout.email.success_order.title_2') !!}</h6></td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>
	</tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table class="body-wrap">
	<tr>
		<td></td>
		<td class="container" bgcolor="#FFFFFF">
			<div class="content" style="box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);">
				<table bgcolor="#FFFFFF" >
					<tr>
						<td>
							<!-- Callout Panel -->
							<img  src="{{ asset('uploads/images/mailing/assets/Ppal_payment_success_order_corbiz.jpg') }}" alt="">
							<div style="padding:15px; color:#666; margin-top:40px; ">
								<h3 style="color:#892CAC; font-weight:800; font-size:21px;">{!! str_replace('{name}', $data['name'], trans('shopping::checkout.email.success_order.p_hi')) !!}</h3>
								<p>{!! trans('shopping::checkout.email.success_order.p_1') !!}</p>
								<p>{!! trans('shopping::checkout.email.success_order.p_2') !!}</p>
								<p style="font-style: italic;">{!! trans('shopping::checkout.email.success_order.p_3') !!}</p>
								<br>
								<p><strong>{!! trans('shopping::checkout.email.success_order.p_4') !!}</strong>
									<ul>
										<li>{!! str_replace('{order}', $data['order'], trans('shopping::checkout.email.success_order.p_5')) !!}</li>
										<li>{!! str_replace('{name}', $data['name'], trans('shopping::checkout.email.success_order.p_6')) !!}</li>
										<li>{!! str_replace('{address}', $data['address'], trans('shopping::checkout.email.success_order.p_7')) !!}</li>
									</ul>
								</p>

								@if (isset($data['items']))
									<p style="margin-top: 25px;">@lang('shopping::checkout.email.success_order.p_11')</p>
									<ul class="cart__confirm-items list-nostyle mul">
										@foreach ($data['items'] as $item)
											<li class="cart__confirm-item">
												<span class="cart__confirm-item__qty">{{ $item->quantity }}</span>
												<span class="cart__confirm-item__name">{{ $item->name }}</span>
												<span class="cart__confirm-item__code">{{ $item->sku }}</span>
												<span class="cart__confirm-item__pts">{{ $item->points }} @lang('shopping::checkout.confirmation.success.points')</span>
												<span class="cart__confirm-item__price">{{ currency_format($item->final_price, \App\Helpers\SessionHdl::getCurrencyKey()) }}</span>
											</li>
										@endforeach
									</ul>

									<p style="text-align: right;">@lang('shopping::checkout.email.success_order.p_12')</p>
									@if (isset($data['detail']['discount'])) <p class="order-info"><span class="desc">@lang('shopping::checkout.quotation.resume_cart.discount'): {{ $data['detail']['discount'] }}</span></p> @endif
									@if (isset($data['detail']['subtotal'])) <p class="order-info"><span class="sub">@lang('shopping::shopping_cart.cart.bill.subtotal'): {{ $data['detail']['subtotal'] }}</span></p> @endif
									@if (isset($data['detail']['points'])) <p class="order-info"><span class="ponts">@lang('shopping::shopping_cart.cart.bill.points'): {{ $data['detail']['points'] }}</span></p> @endif
									@if (isset($data['detail']['management'])) <p class="order-info"><span class="hand">@lang('shopping::shopping_cart.cart.bill.management'): {{ $data['detail']['management'] }}</span></p> @endif
									@if (isset($data['detail']['taxes'])) <p class="order-info"><span class="tax">@lang('shopping::shopping_cart.cart.bill.taxes'): {{ $data['detail']['taxes'] }}</span></p> @endif
									@if (isset($data['detail']['total'])) <p class="order-info"><span class="total">@lang('shopping::shopping_cart.cart.bill.total'): {{ $data['detail']['total'] }}</span></p> @endif
								@endif

								<div style="color:#666; margin-top: 25px;">
									<p>{!! trans('shopping::checkout.email.success_order.p_8') !!}</p>
									<p>{!! str_replace('{CREO}', $finalUrlCREO, trans('shopping::checkout.email.success_order.p_9')) !!}</p>
								</div>
								<!-- social & contact -->

								<div style="width:100%; background-color:#FFFFFF;" align="center">
									<table>
										<tbody>
										<tr>
											<td style="width: 55%;">
												<p style="padding-top: 30px; padding-left: 30px; padding-bottom: 20px;">
													<a href="{{ \Illuminate\Support\Facades\URL::to('/') }}" target="_blank">
														<img width="120" src="{{ $footerLogo }}" alt="">
													</a>
												</p>
											</td>
											<td>
												<p style="padding-top: 30px; padding-bottom: 20px;">
													<a href="https://portal.omnilife.com/contacto" target="_blank" style="padding: 8px;"><img src="{{ asset('/uploads/images/mailing/assets/phone.png') }}" width="27" height="27"/></a>
													<a href="https://www.facebook.com/OmnilifeOficialMexico"  target="_blank" style="padding: 8px;"><img src="{{ asset('/uploads/images/mailing/assets/facebook.png') }}" width="27" height="27"/></a>
													<a href="https://twitter.com/Omnilife"  target="_blank" style="padding: 8px;"><img src="{{ asset('/uploads/images/mailing/assets/twitter.png') }}" width="27"  height="27" /></a>
													<a href="https://www.instagram.com/omnilifeoficial/"  target="_blank" style="padding: 8px;"><img src="{{ asset('/uploads/images/mailing/assets/instagram-02.png') }}" width="27" height="27" /></a>
													<a href="https://www.youtube.com/omnilifeoficial"  target="_blank" style="padding: 8px;"><img src="{{ asset('/uploads/images/mailing/assets/youtube-02.png') }}" width="27" height="27" /></a>
												</p>
											</td>
										</tr>
										</tbody>
									</table>
								</div>
							</div>
						</td>
					</tr>
				</table>
			</div>
		</td>
		<td></td>
	</tr>
</table><!-- /BODY -->

<!-- FOOTER -->
<table class="footer-wrap">
	<tr>
		<td></td>
		<td class="container">
			<!-- content -->
			<div class="content">
				<table>
					<tr>
						<td align="center">
							<p>
								<a href="https://portal.omnilife.com/politicas-de-privacidad">{!! trans('shopping::checkout.email.success_order.p_10') !!}</a>
							</p>
						</td>
					</tr>
				</table>
			</div><!-- /content -->
		</td>
		<td></td>
	</tr>
</table><!-- /FOOTER -->

</body>
</html>