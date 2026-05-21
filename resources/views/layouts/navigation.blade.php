<nav class="w-64 bg-slate-900 text-white min-h-screen fixed flex flex-col">
    <div class="p-6 text-3xl font-bold text-cyan-400 border-b border-slate-700">
        Inmate Food
    </div>

    <div class="mt-8 px-4 space-y-3 flex-1">
        <a href="{{ route('dashboard') }}"
           class="block py-3 px-4 rounded-lg hover:bg-slate-800 transition">
            Dashboard
        </a>

        <a href="{{ route('meals.index') }}"
           class="block py-3 px-4 rounded-lg hover:bg-slate-800 transition">
            Meal Records
        </a>

        <a href="{{ route('ingredients.index') }}"
           class="block py-3 px-4 rounded-lg hover:bg-slate-800 transition">
            Ingredients
        </a>

        <a href="{{ route('meals.create') }}"
           class="block py-3 px-4 rounded-lg hover:bg-slate-800 transition">
            Add Meal
        </a>

        <a href="{{ route('profile.edit') }}"
           class="block py-3 px-4 rounded-lg hover:bg-slate-800 transition">
            Profile
        </a>

        <!-- Logout inside the links section so it's always visible -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full text-left py-3 px-4 rounded-lg text-red-400 hover:bg-red-600 hover:text-white transition">
                Logout
            </button>
        </form>
    </div>
</nav>