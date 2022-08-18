<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" href="{{ asset('images/logo2.ico') }}">
    <title>مبادرة قدم صحيح</title>
    {{-- Splide js --}}
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/js/splide.min.js" integrity="sha256-qtSu/7zFd1zx2GaGN7yAuWyIXuxC7IVrfSpncRDxUII=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide.min.css" integrity="sha256-6YrKt7vMU9e4bwtlblASqhvvEt4/0JEQJ/zyWOFKnaM=" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.0.7/dist/css/splide-core.min.css" integrity="sha256-8gSXJwQPI1Qf6z9TkSJdI1CPinvymYP7xsXFKJC8vUs=" crossorigin="anonymous">

    {{-- Line Awesome --}}
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    {{-- Lordicon --}}
    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>

</head>
<body dir="rtl" class="overflow-x-hidden">
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v14.0&appId=1187955347891453&autoLogAppEvents=1" nonce="rBFjQzyE"></script>
    <div class="w-full h-32 flex py-4 justify-between bg-white fixed z-50 px-2  md:px-2 lg:px-4 xl:px-32" style="--tw-bg-opacity:0.5;">
        <div class="h-full w-32">
            <a href="#"><img class="w-full h-full object-contain" src="{{ asset('images/logo2.png') }}" alt=""></a>
        </div>

        <div class="flex items-center">
            <a href="#"><p class="ml-8 font-bold hover:text-primary-dark">الرئيسية</p></a>
            <a href="#"><p class="ml-8 font-bold hover:text-primary-dark">عن المبادرة</p></a>
            <a href="#"><p class="ml-8 font-bold hover:text-primary-dark">عن المؤسسة</p></a>
            <a href="#"><p class="ml-8 font-bold hover:text-primary-dark">الشركاء</p></a>
            <a href="#"><p class="ml-8 font-bold hover:text-primary-dark">تواصل معنا</p></a>
        </div>
    </div>
    <div dir="ltr" class="w-full relative bg-orange-500 flex items-center justify-center">
        <section data-splide='{"type":"loop"}' class="splide w-full h-full" role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track h-full">
                    <ul class="splide__list text-center h-full">
                        <li class="splide__slide py-80 relative">
                            <img class="w-full h-full absolute top-0 object-cover object-center" src="{{ asset('images/62062_2.jpeg') }}" alt="">
                            <div class="splide__text transition-all duration-700  opacity-0 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                            rounded-lg py-4 lg:py-16 px-8 lg:px-4 xl:px-32 bg-black font-bold text-white text-xl md:text-2xl lg:text-5xl"
                            style="--tw-bg-opacity:0.4">
                        تجربة تجربة</div>
                        </li>
                        <li class="splide__slide py-80 relative">
                            <img class="w-full h-full absolute top-0 object-cover object-center" src="{{ asset('images/10893_1.jpeg') }}" alt="">
                            <div class="splide__text transition-all duration-700  opacity-0 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                            rounded-lg py-4 lg:py-16 px-8 lg:px-4 xl:px-32 bg-black font-bold text-white text-xl md:text-2xl lg:text-5xl"
                            style="--tw-bg-opacity:0.4">
                        تجربة تجربة</div>
                        </li>
                        <li class="splide__slide py-80 relative">
                            <img class="w-full h-full absolute top-0 object-cover object-center" src="{{ asset('images/33662_3.jpeg') }}" alt="">
                            <div class="splide__text transition-all duration-700  opacity-0 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2
                            rounded-lg py-4 lg:py-16 px-8 lg:px-4 xl:px-32 bg-black font-bold text-white text-xl md:text-2xl lg:text-5xl"
                            style="--tw-bg-opacity:0.4">
                        تجربة تجربة</div>
                        </li>
                    </ul>
            </div>
        </section>
    </div>
    <section class="flex w-full justify-center py-4 text-primary-dark px-2  md:px-2 lg:px-4 xl:px-32 flex-wrap lg:flex-nowrap">
        <div class="py-8 px-20 text-center w-full lg:w-auto">
            <i class="las la-stethoscope text-7xl"></i>
            <p class="text-5xl font-bold mt-4 number-increment">25</p>
            <p class="text-3xl">خدمة بالمجان</p>
        </div>
        <div class="py-8 px-20 text-center w-full lg:w-auto">
            <i class="las la-smile text-7xl"></i>
            <p class="text-5xl font-bold mt-4 number-increment">2500</p>
            <p class="text-3xl">خدمة بالمجان</p>
        </div>
        <div class="py-8 px-20 text-center w-full lg:w-auto">
            <i class="las la-bullhorn text-7xl"></i>
            <p class="text-5xl font-bold mt-4 number-increment">150</p>
            <p class="text-3xl">حملة توعية موسعة</p>
        </div>
    </section>
    <section class="px-2 py-20  md:px-2 lg:px-4 xl:px-32 bg-cyan-50">
        <div class="flex justiy-center">
            <h1 class="text-5xl inline-block mx-auto text-center font-bold mb-16 text-primary-light relative">
                عن مبادرة قدم صحيح
                <div class="absolute flex items-center justify-center w-full -bottom-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                    <lord-icon
                        class="w-7 h-7"
                        src="https://cdn.lordicon.com/aixyixpa.json"
                        trigger="loop"
                        delay="3000"
                        colors="primary:#00bcd4">
                    </lord-icon>
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                </div>

            </h1>
        </div>

        <div class="flex py-8 justify-around items-center flex-wrap">
            <img class="object-contain" src="{{ asset('images/logo2.png') }}" alt="">
            <div class="p-8 w-full lg:w-1/3 mt-16 lg:mt-0  text-center">
                <h2 class="text-3xl mb-8">
                    تهدف مبادرة <span class="text-primary-light">قدم صحيح</span> الي
                </h2>
                <p class="text-xl">
                    تقديم خدمات طبية ذات جودة وبالمجان لمرضي القدم السكري غير القادرين ، لتعزيز القدرة علي حماية المرضي من بتر القدم، وكذلك تنظيم حملات موسعة للتوعية بطرق الوقاية من الاصابة بالقدم السكري والحماية من بتر القدم السكري.
                </p>

            </div>
        </div>
    </section>

    <section class="px-2 py-20  md:px-2 lg:px-4 xl:px-32">
        <div class="flex justiy-center">
            <h1 class="text-5xl inline-block mx-auto text-center font-bold mb-16 text-primary-light relative">
                عن مؤسسة صناع الخير
                <div class="absolute flex items-center justify-center w-full -bottom-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                    <script src="https://cdn.lordicon.com/xdjxvujz.js"></script>
                    <lord-icon
                        class="w-7 h-7"
                        src="https://cdn.lordicon.com/aixyixpa.json"
                        trigger="loop"
                        delay="3000"
                        colors="primary:#00bcd4">
                    </lord-icon>
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                </div>

            </h1>
        </div>

        <div class="flex py-8 justify-around items-center flex-wrap-reverse">
             <div class="p-8 w-full lg:w-1/3 mt-16 lg:mt-0  text-center">
                <h2 class="text-3xl mb-8">
                   مؤسسة <span class="text-primary-light">صناع الخير</span>
                </h2>
                <p class="text-xl">
                    مؤسسة خيرىة تنموية ورائدة في مجال الرعاية والخدمات الطبية لغير القادرين وتقديم المشروعات التنموية
                </p>
                <a href="http://sona3elkhair.com/" target="_blank"><button class="mt-4 py-4 px-8 bg-primary-dark text-white text-2xl transition-colors hover:bg-primary-light">
                    زيارة موقع المؤسسة
                </button></a>
            </div>
            <img class="object-contain w-1/2 lg:w-1/3 xl:w-1/4" src="{{ asset('images/sona3-elkheir.jpg') }}" alt="">

        </div>
    </section>

    <section class="px-2 py-20  md:px-2 lg:px-4 xl:px-32 bg-cyan-50">
        <div class="flex justiy-center">
            <h1 class="text-5xl inline-block mx-auto text-center font-bold mb-16 text-primary-light relative">
                آخر الأخبار
                <div class="absolute flex items-center justify-center w-full -bottom-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>

                    <lord-icon
                        class="w-7 h-7"
                        src="https://cdn.lordicon.com/ofqzcdla.json"
                        trigger="loop"
                        delay="3000"
                        colors="primary:#00bcd4">
                    </lord-icon>
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                </div>
            </h1>
        </div>
        <div class="mx-auto  grid grid-cols-1 lg:grid-cols-2 gap-2 justify-center content-center">
            <div class="fb-post bg-white flex items-center justify-center" style="display:flex;" data-href="https://www.facebook.com/Youm7/posts/pfbid0bx9yguRoV6NUnJuahnCBnbnXvRvzx8UxpSymu2fab2XctX4c5K5giwNjYdSxa9o9l" data-show-text="true"><blockquote cite="https://www.facebook.com/20531316728/posts/10154009990506729/" class="fb-xfbml-parse-ignore">Posted by <a href="https://www.facebook.com/facebook/">Facebook</a> on&nbsp;<a href="https://www.facebook.com/20531316728/posts/10154009990506729/">Thursday, August 27, 2015</a></blockquote></div>
            <div class="fb-post bg-white flex items-center justify-center" style="display:flex;" data-href="https://www.facebook.com/kadamsaheh/posts/pfbid0VzHcM4BZLe8kTmZHvWXGYSec8yGqbuKtxniqLmdWub5C7eMtQmurVE8d7wZWW6n7l" data-show-text="true"><blockquote cite="https://www.facebook.com/20531316728/posts/10154009990506729/" class="fb-xfbml-parse-ignore">Posted by <a href="https://www.facebook.com/facebook/">Facebook</a> on&nbsp;<a href="https://www.facebook.com/20531316728/posts/10154009990506729/">Thursday, August 27, 2015</a></blockquote></div>
        </div>
    </section>

      <section class="px-2 py-20  md:px-2 lg:px-4 xl:px-32">
        <div class="flex justiy-center">
            <h1 class="text-5xl inline-block mx-auto text-center font-bold mb-16 text-primary-light relative">
                شركاء النجاح
                <div class="absolute flex items-center justify-center w-full -bottom-8 left-1/2 transform -translate-x-1/2">
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                    <lord-icon
                        class="w-7 h-7"
                        src="https://cdn.lordicon.com/hjeefwhm.json"
                        trigger="loop"
                        delay="3000"
                        colors="primary:#00bcd4">
                    </lord-icon>
                    <div class="w-1/3 border-y-2 border-primary-light mx-2"></div>
                </div>
            </h1>
        </div>
        <div dir="ltr">

        <section data-splide='{"type":"loop","perPage":"3"}' class="splide w-full cursor-grab active:cursor-grabbing " role="group" aria-label="Splide Basic HTML Example">
            <div class="splide__track ">
                    <ul class="splide__list text-center ">
                        <li class="splide__slide">
                            <div class="w-3/4 bg-white shadow-xl px-8 py-8 my-8 transform scale-100 border-8 ring-8 ring-white border-white hover:ring-cyan-50 hover:border-cyan-50 hover:scale-90 transition-all duration-300">
                                <img class="w-full h-full" src="{{ asset('images/ministry-of-health-and-population-logo.jpg') }}" alt="">
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="w-3/4 bg-white shadow-xl px-8 py-8 my-8 transform scale-100 border-8 ring-8 ring-white border-white hover:ring-cyan-50 hover:border-cyan-50 hover:scale-90 transition-all duration-300">
                                <img class="w-full h-full" src="{{ asset('images/ministry-of-social-solidarity-logo.png') }}" alt="">
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="w-3/4 bg-white shadow-xl px-8 py-8 my-8 transform scale-100 border-8 ring-8 ring-white border-white hover:ring-cyan-50 hover:border-cyan-50 hover:scale-90 transition-all duration-300">
                                <img class="w-full h-full" src="{{ asset('images/al-azhar-university.jpeg') }}" alt="">
                            </div>
                        </li>
                    </ul>
            </div>
        </section>
        </div>
    </section>
    <script>
        let splide_list = document.querySelectorAll('.splide__list li');
        let current_slide = 0;
        splide_list[current_slide].querySelector('.splide__text').classList.remove('opacity-0');
        let splides = document.querySelectorAll('.splide');
        splide = null;
        for (let i = 0; i< splides.length; i++){
            let x = new Splide( splides[i] ).mount();
            if(i == 0){
                splide = x;
            }
        }
        splide.on( 'move', function (newIndex) {
            if(current_slide != newIndex){
                if(splide_list[current_slide].querySelector('.splide__text') !== null){
                splide_list[current_slide].querySelector('.splide__text').classList.add('opacity-0');
                splide_list[current_slide].querySelector('.splide__text').classList.remove('-translate-y-1/2');
                splide_list[current_slide].querySelector('.splide__text').classList.add('translate-y-80');
                }
                current_slide = newIndex;
                if(splide_list[current_slide].querySelector('.splide__text') !== null){
                    splide_list[current_slide].querySelector('.splide__text').classList.remove('opacity-0');
                    splide_list[current_slide].querySelector('.splide__text').classList.add('-translate-y-1/2');
                splide_list[current_slide].querySelector('.splide__text').classList.remove('translate-y-80');
                }
            }
        } );

        let number_increment = document.querySelectorAll('.number-increment');
        const elementInView = (el, scrollOffset = 0) => {
            const elementTop = el.getBoundingClientRect().top;

            return (
                elementTop <=
                ((window.innerHeight || document.documentElement.clientHeight) - scrollOffset)
            );
        };

        number_increment.forEach(function(item){
            let number = item.innerHTML;
            let number_increment = 0;
            let binded = false;
            function increment(){
                if(elementInView(item, 50) && !binded){
                    binded = true;
                let interval = setInterval(function(){
                    number_increment+= number/100;
                    item.innerHTML = Math.floor(number_increment);
                    if(number_increment >= number){
                        item.innerHTML = number;
                        clearInterval(interval);
                    }
                },10);
                }
            }
            window.addEventListener('scroll', () => {
                increment();
            } );

            window.addEventListener('resize', () => {
                increment();
            } );

            window.addEventListener('load', () => {
                increment();
            } );

        } );


    </script>
</body>
</html>
