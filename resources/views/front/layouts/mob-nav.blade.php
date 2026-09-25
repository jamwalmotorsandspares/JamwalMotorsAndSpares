<div class="mobile-nav-wrapper" role="navigation">
    <div class="closemobileMenu"><i class="icon cps cp-times pull-right"></i> {{$setting->name}}</div>
    <ul id="MobileNav" class="mobile-nav">
        <li class="lvl1"><a href="{{ url('/') }}" class="active">@lang('site.home')</a></li>
        <li class="lvl1"><a href="{{ route('products.index') }}">@lang('site.products')</a></li>
        <li class="lvl1 parent"><a href="#">@lang('site.categories') <i class="cps cp-plus"></i></a>
            <ul>
                @foreach ($primary_categories as $primary_category)
                <li>
                    <a class="title text-uppercase" href="#">{{ $primary_category->name }} <i
                            class="cps cp-plus"></i></a>
                    <ul class="m-items lvl-1">
                        @foreach ($primary_category->subCategories as $sub_category)
                        <li><a href="{{ route('products.index') . '?category_id=' . $sub_category->id }}" class="site-nav">{{ $sub_category->name }}</a></li>
                        @endforeach
                    </ul>
                </li>
                @endforeach
            </ul>
        </li>
        @guest
        <li class="lvl1"><a href="{{ route('login') }}">@lang('site.login') & @lang('site.register')</a></li>
        @else
        <li class="lvl1"><a href="{{ route('users.index') }}">@lang('site.my_account')</a></li>
        <li class="lvl1"><a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-mob').submit();"> @lang('site.logout')<form id="logout-mob" action="{{ route('logout') }}" method="POST"
            style="display: none;">
            @csrf
        </form></a></li>
        @endguest
        <li class="social">
            <div class="list-inline m-0 social-icons">
                {{-- <span class="list-inline-item"><a href="#;" target="_blank" title="Facebook"><i
                            class="cpb cp-facebook-f"></i></a></span>
                <span class="list-inline-item"><a href="#;" target="_blank" title="Twitter"><i
                            class="cpb cp-twitter"></i></a></span>
                <span class="list-inline-item"><a href="#;" target="_blank" title="Instagram"><i
                            class="cpb cp-instagram"></i></a></span>
                <span class="list-inline-item"><a href="#;" target="_blank" title="Google Plus"><i
                            class="cpb cp-google-plus"></i></a></span>
                <span class="list-inline-item"><a href="#;" target="_blank" title="Linked In"><i
                            class="cpb cp-linkedin-in"></i></a></span>
                <span class="list-inline-item"><a href="#;" target="_blank" title="Youtube"><i
                            class="cpb cp-youtube"></i></a></span> --}}
                 @if(!empty($setting?->facebook_url))
                         <span class="list-inline-item"><a href="{{ $setting->facebook_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"><i class="cpb cp-facebook-f"></i></a></span>
                        @endif
                        @if(!empty($setting?->twitter_url))
                            <span class="list-inline-item"><a href="{{ $setting->twitter_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="X"><i class="cpb cp-twitter"></i></a></span>
                        @endif
                        @if(!empty($setting?->instagram_url))
                            <span class="list-inline-item"><a href="{{ $setting->instagram_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"><i class="cpb cp-instagram"></i></a></span>
                        @endif
                         @if(!empty($setting?->whatsapp_url))
                                <span class="list-inline-item"><a href="{{ $setting->whatsapp_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="WhatsApp"><i class="cpb cp-whatsapp"></i></a></span>
                        @endif
                        @if(!empty($setting?->linkedin_url))
                            <span class="list-inline-item"><a href="{{ $setting->linkedin_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn"><i class="cpb cp-linkedin-in"></i></a></span>
                        @endif
                        @if(!empty($setting?->youtube_url))
                            <span class="list-inline-item"><a href="{{ $setting->youtube_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="YouTube"><i class="cpb cp-youtube"></i></a></span>
                        @endif
            </div>
        </li>
    </ul>
</div>
