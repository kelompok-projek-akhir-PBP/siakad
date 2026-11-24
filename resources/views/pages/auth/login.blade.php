<x-layout.master title="Login">
    <form action="{{ route('login.post') }}" method="POST" class="max-w-125 m-5">
        @csrf

        <div class="mb-3">
            <x-ui.input
                name="email"
                label="Email"
                type="email"
                placeholder="example@gmail.com"
                required
                value="{{ old('email') }}"
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

        <div class="flex gap-3">
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Ingat saya</label>
        </div>

        <a href="{{ route('password.request') }}">Lupa Password</a>

        <x-ui.button variant="primary" type="submit">Login</x-ui.button>
    </form>
</x-layout.master>
