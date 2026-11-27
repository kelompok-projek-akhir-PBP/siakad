<x-layout.app title="Login SIAKAD">

    <div class="flex flex-col md:flex-row min-h-screen md:h-screen md:overflow-hidden">

        <form action="{{ route('login.post') }}" method="POST" class="w-full md:w-2/3 min-h-screen flex items-center justify-center">
            @csrf
    
            <div class="w-full max-w-md">
                <x-ui.card title="Login SIAKAD" class="bg-linear-to-br from-primary to-primary-subtle">
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
                </x-ui.card>
            </div>
        </form>
    
        <div class="w-full md:w-1/3 bg-linear-to-r from-primary to-primary-subtle">
            <img src="{{ asset('assets/login_banner.jpg') }}" alt="login_banner">
        </div>

    </div>

</x-layout.app>
