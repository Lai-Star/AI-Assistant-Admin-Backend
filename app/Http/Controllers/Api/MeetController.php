<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\AuthController;
use App\Repositories\UserRepository;

class MeetController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $userRepository;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);

        if ($token) {
            $response = [
                'google_api_key' => 'YOUR_GOOGLE_MEET_API_KEY',
                'zoom_api_key' => 'YOUR_ZOOM_API_KEY',
                'teams_api_key' => 'YOUR_MS_TEAMS_API_KEY'
            ];

            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
    }

    public function create(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        
        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);

        if ($token) {
            switch ($request->input('meeting_type')) {
                case 'googleMeet':
                    $meeting_url = "https://meet.google.com/";
                    $meeting_id = uniqid('googleMeet_');
                    $meeting_passcode = random_int(0, 10);
                    break;
    
                case 'zoom':
                    $meeting_url = "https://zoom.us/j/";
                    $meeting_id = uniqid('zoom_');
                    $meeting_passcode = random_int(0, 10);
                    break;
    
                case 'msTeams':
                    $meeting_url = "https://teams.microsoft.com/l/meetup-join/";
                    $meeting_id = uniqid('teams_');
                    $meeting_passcode = random_int(0, 10);
                    break;
    
                default:
                    return response()->json(['message' => 'Invalid Meet Type'], 400);
                    break;
            };
    
            $response = [
                'meeting_type' => $request->input('meeting_type'),
                'meeting_url' => $meeting_url,
                'meeting_id' => $meeting_id,
                'meeting_passcode' => $meeting_passcode
            ];
    
            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
    }

    public function join(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'meeting_url' => 'required|string',
            'meeting_id' => 'required|string|',
            'meeting_passcode' => 'required|string|'
        ]);

        $credentials = $request->only('email', 'password');
        $token = auth('api')->attempt($credentials);

        if ($token) {
            $response = [
                'start_meeting' => true,
            ];
            return response()->json($response, 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 400);
        }
    }
}
