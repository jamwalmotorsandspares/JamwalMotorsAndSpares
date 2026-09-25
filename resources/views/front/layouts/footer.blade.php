<footer class="footer" id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="newsletter mb-3">
                        <h4 class="title">Our Newsletter</h4>
                    </div>
                    <div class="social-col mb-3 clearfix">
                        @if(!empty($setting?->facebook_url))
                            <a href="{{ $setting->facebook_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Facebook"><i class="cpb cp-facebook-f"></i></a>
                        @endif
                        @if(!empty($setting?->twitter_url))
                            <a href="{{ $setting->twitter_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="X"><i class="cpb cp-twitter"></i></a>
                        @endif
                        @if(!empty($setting?->instagram_url))
                            <a href="{{ $setting->instagram_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="Instagram"><i class="cpb cp-instagram"></i></a>
                        @endif
                         @if(!empty($setting?->whatsapp_url))
                                <a href="{{ $setting->whatsapp_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="WhatsApp"><i class="cpb cp-whatsapp"></i></a>
                        @endif
                        @if(!empty($setting?->linkedin_url))
                            <a href="{{ $setting->linkedin_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="LinkedIn"><i class="cpb cp-linkedin-in"></i></a>
                        @endif
                        @if(!empty($setting?->youtube_url))
                            <a href="{{ $setting->youtube_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            aria-label="YouTube"><i class="cpb cp-youtube"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="footer-col contact-col">
                        <h4 class="title">Contact</h4>
                        <ul>
                            <li><a href="tel:{{$setting->phone}}"><i class="cps cp-phone"></i> {{$setting->phone}} , +919469326126 </a>
                            {{-- <a href="tel:{{$setting->phone}}"><i class="cps cp-phone"></i>+919469326126 </a> --}}
                            </li>
                            <li><i class="cps cp-map-marker"></i> {{$setting->address}}</li>
                            <li><i class="cps cp-clock"></i> 09:30am - 09:30pm (Mon - Sun)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p>Copyright &copy; <?=date('Y')?> JAMWAL MOTORS AND SPARES. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
