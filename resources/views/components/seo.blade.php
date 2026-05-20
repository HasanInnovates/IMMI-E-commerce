@php $siteName = website_setting('website_name', config('app.name')); @endphp

<meta name="description" content="{{ $description ?? $siteName . ' - Your premier online shopping destination.' }}">
<meta name="keywords" content="{{ $keywords ?? 'ecommerce, shop, online store, laravel' }}">
<meta name="author" content="{{ $siteName }}">
<meta name="robots" content="index, follow">

<meta property="og:title" content="{{ $title ?? $siteName }}">
<meta property="og:description" content="{{ $description ?? 'Shop the best products online.' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:site_name" content="{{ $siteName }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $title ?? $siteName }}">
<meta name="twitter:description" content="{{ $description ?? 'Shop the best products online.' }}">

<link rel="canonical" href="{{ url()->current() }}">
