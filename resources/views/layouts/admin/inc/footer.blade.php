<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        {{ __('Anything you want') }}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ now()->year }}-{{ now()->addYear()->year }} <a
            href="{{ url('/') }}">{{ env('APP_NAME') }}</a>.</strong> {{ __('All rights reserved.') }}
</footer>
