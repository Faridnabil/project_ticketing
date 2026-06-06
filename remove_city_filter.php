<?php
$files = [
    'c:\laragon\www\project_ticketing\resources\views\dashboard\admin\home\indexProblem.blade.php',
    'c:\laragon\www\project_ticketing\resources\views\dashboard\helpdesk\home\indexProblem.blade.php',
    'c:\laragon\www\project_ticketing\resources\views\dashboard\koordinator\home\indexProblem.blade.php',
    'c:\laragon\www\project_ticketing\resources\views\dashboard\pejabat\home\indexProblem.blade.php',
    'c:\laragon\www\project_ticketing\resources\views\dashboard\siak-dev\home\indexProblem.blade.php',
    'c:\laragon\www\project_ticketing\resources\views\dashboard\staff-subdit\home\indexProblem.blade.php',
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);

    // 1. Remove the col-md-2 div containing city_id select.
    // We match from `<div class="col-md-2">` that contains `<select class="form-select" id="city_id"` to the next `</div>` that closes it.
    // It's easier to match the label and select exactly.
    $pattern = '/<div class="col-md-2">\s*<label for="city_id".*?<\/div>\s*(<div class="col-md-2 d-flex align-items-end">)/s';
    $content = preg_replace($pattern, '$1', $content);

    // Also change the remaining button div to col-md-4 to take up the space
    $content = str_replace('<div class="col-md-2 d-flex align-items-end">', '<div class="col-md-4 d-flex align-items-end">', $content);

    // 2. Remove the JS for #province_id change.
    // We match `$('#province_id').change(...)` or `$('#province_id').on('change', ...)`
    // Since there might be comments like `// Dynamic city dropdown...` we match from that.
    $pattern2 = '/(\/\/ Dynamic city dropdown based on province selection\s*)?\$\(\'#province_id\'\)\.change\(function\(\)\s*\{.*?(?=\$\(\'#resetFilter\')/s';
    $content = preg_replace($pattern2, '', $content);

    // 3. Remove the line resetting #city_id
    $pattern3 = '/\$\(\'#city_id\'\).*?;/m';
    $content = preg_replace($pattern3, '', $content);

    file_put_contents($file, $content);
    echo "Processed $file\n";
}
