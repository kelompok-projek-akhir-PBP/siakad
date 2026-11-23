<x-layout.master title="Login">
    <form action="{{ route('login.post') }}" method="POST" class="max-w-125 m-5">
        @csrf

        <div class="mb-3">
            <x-ui.input
                name="email"
                label="Email"
                {{-- type="email" --}}
                placeholder="example@gmail.com"
                required
                value="{{ old('email') }}"
            />
        </div>

        <div class="mb-3">
            <x-ui.input
                name="password"
                label="Password"
                {{-- type="password" --}}
                placeholder="********"
                min=3
                required
            />
        </div>

        <x-ui.button variant="primary" type="submit">Login</x-ui.button>
    </form>
</x-layout.master>
