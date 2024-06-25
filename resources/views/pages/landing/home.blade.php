<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- style -->
    @vite('resources/css/app.css')

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- endstyle -->

    <title>Anecake | Aneka Kue Basah</title>
</head>

<body class="antialiased bg-base-100 overscroll-none">
    <header class="sticky top-0 z-40">
        @include('pages.landing.navbar')
    </header>
    <main class="main-container">
        <section>
            <div class="hero bg-base-200 max-h-screen">
                <div class="hero-content w-full flex-col lg:flex-row-reverse">
                    <img src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.jpg"
                        class="max-w-sm rounded-lg shadow-2xl" />
                    <div>
                        <h1 class="text-5xl font-bold">Box Office News!</h1>
                        <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi
                            exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
                        <button class="btn btn-primary">Get Started</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-base-200 p-8">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <h1 class="text-2xl font-bold mb-2">Produk</h1>
                        <p class="mb-4">Produk ini ada berbagai macam</p>
                    </div>
                    <!-- Slider main container -->
                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            @foreach ($dataProduk as $item)
                                <div class="swiper-slide">
                                    <img src="{{ $item['gambar'] }}" class="w-full h-72" alt="">
                                </div>
                            @endforeach
                        </div>
                        <!-- If we need pagination -->
                        <div class="swiper-pagination"></div>

                        <!-- If we need navigation buttons -->
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>

                        <!-- If we need scrollbar -->
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <h2>ini halaman landing section 3</h2>
        </section>
    </main>

    <!-- script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
            },

            // Autoplay parameters
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
        });
    </script>
    <!-- endscript -->
</body>

</html>
