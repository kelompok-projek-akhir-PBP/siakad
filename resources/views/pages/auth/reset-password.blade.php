<x-layout.app title="Reset Password">
    <form action="{{ route('password.update') }}" method="POST" class="max-w-125 m-5">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="mb-3">
            <x-ui.input
                name="email"
                label="Email"
                type="email"
                placeholder="example@gmail.com"
                required
                value="{{ request('email') }}"
            />
        </div>

        <div class="mb-3">
            <x-ui.input
                name="password"
                label="Password"
                type="password"
                placeholder="********"
                min=3
                required
            />
        </div>

        <div class="mb-3">
            <x-ui.input
                name="password_confirmation"
                label="password_confirmation"
                type="password"
                placeholder="********"
                min=3
                required
            />
        </div>

        <x-ui.button variant="primary" type="submit">Reset Password</x-ui.button>
    </form>
</x-layout.app>
