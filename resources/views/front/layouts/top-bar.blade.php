<div class="top-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 d-flex justify-content-lg-start justify-content-center">
                <span class="phone-top d-flex align-items-center"> <a href="tel:917006291696"><i class="icon cps cp-phone align-middle px-1"></i> <span class="label">{{$setting->phone}}</span></a></span>
                <span class="language-dropdown top-dropdown d-flex align-items-center">
                    <i class="cps cp-language"></i>
                    <ul class="nav">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <li class="nav-item"><a class="nav-link {{$localeCode == app()->getLocale() ? 'active' : ''}}" rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">{{ $properties['native'] }}</a></li>
                        @endforeach
                    </ul>
                </span>
            </div>
            <div class="col-xl-4 d-md-flex d-none justify-content-center p-0"></div>
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4 justify-content-end d-none d-lg-flex">
                @if (Auth::user())
                <div class="setting-link">
                    <a href="javascript:void(0);"><i class="cp cp-user-circle"></i> <span class="label">{{Auth::user()->first_name}}</span></a>
                    <div id="settingsBox">
                        <ul>
                            <li><a href="{{ route('users.index') }}">@lang('site.my_account')</a></li>
                            <li><a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                          document.getElementById('logout-bar').submit();">@lang('site.logout')</a>
                                <form id="logout-bar" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form></li>
                        </ul>
                    </div>
                </div>
                @endif
                <ul class="list-inline m-0 social-icons ">
                 @if(!empty($setting?->facebook_url))
                    <li class="list-inline-item"><a href="{{ $setting->facebook_url }}" target="_blank" rel="noopener noreferrer" title="Facebook" aria-label="Facebook"><i class="cpb cp-facebook-f"></i></a></li>
                @endif
                @if(!empty($setting?->twitter_url))
                    <li class="list-inline-item"><a href="{{ $setting->twitter_url }}" target="_blank" rel="noopener noreferrer"
                                aria-label="X" title="Twitter"><i class="cpb cp-twitter"></i></a></li>
                @endif
                @if(!empty($setting?->instagram_url))
                    <li class="list-inline-item"><a href="{{ $setting->instagram_url }}"  rel="noopener noreferrer"
                                aria-label="Instagram" target="_blank" title="Instagram"><i class="cpb cp-instagram"></i></a></li>
                @endif
                @if(!empty($setting?->whatsapp_url))
                    <li class="list-inline-item"><a href="{{ $setting->whatsapp_url }}" target="_blank"  rel="noopener noreferrer"
                            aria-label="WhatsApp" title="WhatsApp"><i class="cpb cp-whatsapp"></i></a></li>
                @endif
                @if(!empty($setting?->linkedin_url))
                    <li class="list-inline-item"><a href="{{ $setting->linkedin_url }}" target="_blank" rel="noopener noreferrer"
                        aria-label="LinkedIn" title="Linked In"><i class="cpb cp-linkedin-in"></i></a></li>
                @endif
                @if(!empty($setting?->youtube_url))
                    <li class="list-inline-item"><a href="{{ $setting->youtube_url }}" target="_blank" rel="noopener noreferrer"
                 aria-label="YouTube" title="Youtube"><i class="cpb cp-youtube"></i></a></li>
                @endif
                </ul>
            </div>
        </div>
    </div>
</div>
