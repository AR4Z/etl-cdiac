<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\General\UserRepository;
use App\Repositories\Users\RoleRepository;
use App\Repositories\Users\ApplicationRepository;
use App\Repositories\Users\RoleApplicationRepository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    protected $userRepository;
    protected $roleRepository;
    protected $applicationRepository;
    protected $roleApplicationRepository;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository,
        ApplicationRepository $applicationRepository,
        RoleApplicationRepository $roleApplicationRepository
    ) {
        $this->middleware('admin');
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->applicationRepository = $applicationRepository;
        $this->roleApplicationRepository = $roleApplicationRepository;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'identification_document' => ['required', 'unique:user'],
            'institution' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:user'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function create(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }
        $request['password'] = str_random(8);
        $user = $this->userRepository->createUser($request->all());

        if ($request->application == 'all') {
            $all_apps = $this->applicationRepository->getAll();
            foreach ($all_apps as $app) {
                $this->roleApplicationRepository->createRoleApp(['role_id' => $request->rol, 'application_id' => $app->id, 'user_id' => $user->id]);
            }
        } else {
            $this->roleApplicationRepository->createRoleApp(['role_id' => $request->rol, 'application_id' => $request->application, 'user_id' => $user->id]);
        }
        $user->sendVerification($request->email, $request->password);
        return redirect('register');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'institution' => 'required',
            'rol' => 'required'
        ]);

        return view('auth.test');
    }

    public function showRegistrationForm()
    {
        return view('auth.register')->with([
            'roles' => $this->roleRepository->getAll(),
            'applications' => $this->applicationRepository->getAll()
        ]);
    }
}
