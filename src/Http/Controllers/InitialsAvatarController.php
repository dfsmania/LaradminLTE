<?php

namespace DFSmania\LaradminLte\Http\Controllers;

use DFSmania\LaradminLte\Support\Avatars\InitialsAvatarGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InitialsAvatarController extends Controller
{
    /**
     * Generate and show a local SVG avatar with the initials of the given
     * name.
     *
     * @param  Request  $request
     * @return Response
     */
    public function show(Request $request): Response
    {
        // Validate the request to ensure that the 'name' parameter is present
        // and is a string.

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        // Retrieve the configuration for the initials avatar generator, and
        // create an instance of the generator with the validated name.

        $config = config('ladmin.auth.profile_images.local_initials', []);
        $generator = new InitialsAvatarGenerator($validated['name'], $config);

        // Generate the SVG markup for the avatar and return it as a response
        // with the appropriate headers for content type and caching.

        return response($generator->toSvg())
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=86400');
    }
}
