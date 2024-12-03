<div class="flex-1 ">
    <!-- Header -->
    <header class="bg-white shadow-md w-full h-1/8">
      <div class="flex items-center justify-between p-4">
        <div class="flex items-center space-x-4">
          <button id="menu-toggle" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-bars text-xl"></i>
          </button>
          <div class="relative">
            <input
              type="text"
              placeholder="Search..."
              class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
            />
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <button class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-bell text-xl"></i>
          </button>
          <div class="flex items-center space-x-2">
            <img
              src="https://ui-avatars.com/api/?name=Admin+User"
              alt="Profile"
              class="w-8 h-8 rounded-full"
            />
            <span class="text-gray-700">Admin User</span>
          </div>
          <i class="fa fa-sign-out" id="logout" aria-hidden="true"></i>
        </div>
      </div>
    </header>
