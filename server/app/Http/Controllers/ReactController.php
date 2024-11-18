<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReactController extends Controller
{
    public function redirectStatic(Request $request, $path)
    {

        $hostname = $request->server('HTTP_HOST');
        $https = $request->secure() ? "https" : "http";

        // Check if the request is coming from localhost
        if (preg_match("/localhost/", $hostname)) {
            // Redirect to localhost:3000 for files under /static
            return redirect()->away('http://localhost:3000/static/js/bundle.js');
        } else {

            $directory = implode(DIRECTORY_SEPARATOR, [
                base_path(), 'react-js','build', 'static', $path
            ]);

            $files = array_filter(File::files($directory), function ($fileName) use ($path) {
                $pattern = '/main\.[A-z0-9]{1,}\.'. $path . '$/';
                return preg_match($pattern, $fileName);
            });

            $fileName = explode(DIRECTORY_SEPARATOR, array_values($files)[0]);
            $endFile = $fileName[count($fileName) - 1];

            // Redirect to etorrefranca.site/public/bundle.js for etorrefranca.site
            return redirect()->away("$https://$hostname/react-js/build/static/$path/$endFile");
        }
    }
}
