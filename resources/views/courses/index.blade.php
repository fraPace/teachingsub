@include('layouts.index', [
    "resource" => $course,
    "resources" => $courses,
    "resource_base_route" => "courses",
    "resource_name" => "Course",
    "resource_name_plural" => "Courses",
    "extra_variables" => [
    ]
])
