<aside>

    <div class=" list-group">
        <a href="{{ route('page.home') }}" class=" list-group-item list-group-item-action">
            Home
        </a>
    </div>

    @notUser
        <p class="mt-3 my-2"></p>

        <div class=" list-group">
            <a href="{{ route('auth.login') }}" class=" list-group-item list-group-item-action">
                Login
            </a>
            <a href="{{ route('auth.register') }}" class=" list-group-item list-group-item-action">
                Register
            </a>
        </div>
    @endnotUser

    @user
        <p class="mt-3 my-2">Dashboard</p>
        <div class=" list-group">
            <a href="{{ route('dashboard.home') }}" class=" list-group-item list-group-item-action">
                Dashboard
            </a>
        </div>


        <p class="mt-3 my-2">Manage Category</p>

        <div class=" list-group">
            <a href="{{ route('category.create') }}" class=" list-group-item list-group-item-action">
                Create Category
            </a>
            <a href="{{ route('category.index') }}" class=" list-group-item list-group-item-action">
                Category List
            </a>
        </div>

        <p class="mt-3 my-2">Manage Inventory</p>

        <div class=" list-group">
            <a href="{{ route('item.create') }}" class=" list-group-item list-group-item-action">
                Create Item
            </a>
            <a href="{{ route('item.index') }}" class=" list-group-item list-group-item-action">
                Item List
            </a>
        </div>

        <p class="mt-3 my-2">User Profile</p>

        <div class=" list-group">
            <a href="" class=" list-group-item list-group-item-action">
                My Profile
            </a>
            <a href="{{ route('auth.passwordChange') }}" class=" list-group-item list-group-item-action">
                Change Password
            </a>

        </div>

        <form action="{{ route('auth.logout') }}" method="post">
            @csrf
            <button class=" btn btn-primary d-block w-100 mt-3">Logout</button>
        </form>
    @enduser






</aside>
