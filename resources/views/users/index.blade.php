@include('layouts.index', [
    "resource" => $user,
    "resources" => $users,
    "resource_base_route" => "users",
    "resource_name" => "User",
    "resource_name_plural" => "Users",
    "extra_variables" => [
        "password" => true
    ]
])