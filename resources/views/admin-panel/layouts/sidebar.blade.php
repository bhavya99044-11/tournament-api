<aside class="bg-indigo-800 text-white w-64 flex flex-col fixed h-full">
    <div class="p-4">
      <h2 class="text-2xl font-bold">Admin Panel</h2>
    </div>
    <nav class="flex-1 p-4">
      <ul class="space-y-2">
        <li>
          <a href="{{route('admin.dashboard')}}" class="flex items-center space-x-2 p-2 hover:bg-indigo-700 rounded-lg">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{route('tournament.index')}}" class="flex items-center space-x-2 p-2 hover:bg-indigo-700 rounded-lg">
            <i class="fas fa-users"></i>
            <span>Tournaments</span>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center space-x-2 p-2 hover:bg-indigo-700 rounded-lg">
            <i class="fas fa-chart-bar"></i>
            <span>Analytics</span>
          </a>
        </li>
        <li>
          <a href="#" class="flex items-center space-x-2 p-2 hover:bg-indigo-700 rounded-lg">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </a>
        </li>
      </ul>
    </nav>
  </aside>
