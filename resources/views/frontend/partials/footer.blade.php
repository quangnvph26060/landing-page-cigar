<div class="text-white text-center">
    <img src="{{ showImage($config->logo) }}" alt="Xi Ga Tot" class="footer-logo mb-3" />
    <p class="mb-3 text-start ">
        {{ $config->description }}
    </p>

    <h5 class="fw-bold text-start">VỀ CHÚNG TÔI</h5>

    <ul class="list-unstyled text-start d-inline-block w-100">
        <li class="d-flex align-items-center mb-2">
            <i class="fas fa-home me-2"></i>
            <span>Địa chỉ: {{ $config->address }}</span>
        </li>
        <li class="d-flex align-items-center mb-2">
            <i class="fas fa-phone-alt me-2"></i>
            @php
                $cleanHotline = preg_replace('/[^0-9]/', '', $config->hotline);
            @endphp
            <a href="tel:{{ $cleanHotline }}" class="text-decoration-none" style="color: white">
                Hotline: {{ $config->hotline }}
            </a>
        </li>

        <li class="d-flex align-items-center mb-2">
            <i class="fas fa-envelope me-2"></i>
            <a href="mailto:{{ $config->email }}" class="text-decoration-none" style="color: white">
                Email: {{ $config->email }}
            </a>
        </li>

        <li class="d-flex align-items-center">
            <i class="fas fa-globe me-2"></i>
            <span>Website:
                <a href="{{ $config->website }}" class="text-white">{{ $config->website }}</a></span>
        </li>
    </ul>
</div>
