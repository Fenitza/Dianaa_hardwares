<?php

namespace App\Http\Controllers;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CareersController extends Controller
{
    public function index()
    {
        return view('pages.careers');

    }
    public function admin()
    {
        $jobs = Job::all();
        return view('includes.admin.careers.index',compact('jobs'));

    }
    public function showCareersPage()
    {
        $jobs = Job::all(); // Assuming you have a Job model that retrieves data from a jobs table
        return view('pages.careers', compact('jobs'));
    }

    public function show($id)
{
    $job = Job::findOrFail($id);
    return view('pages.job_detail', compact('job'));
}

public function apply(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email',
        'qualification' => 'required|string',
        'phone' => 'nullable|string',
        'message' => 'required|string',
    ]);

    $job = Job::findOrFail($id);

    // Send email
    Mail::raw("Job Application for: {$job->title}\n\nFrom: {$validated['name']}\nEmail: {$validated['email']}\nQualification: {$validated['qualification']}\nPhone: {$validated['phone']}\n\nMessage:\n{$validated['message']}", function ($message) use ($validated) {
        $message->to('dianaafastners@gmail.com') // 🔁 change to your receiving email
                ->subject('New Job Application');
    });

    return back()->with('success', 'Your application has been submitted!');
}
    public function create()
    {
        return view('includes.admin.careers.create');
    }

    // Store new job in database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'nullable|string|max:255',
        ]);

        Job::create($validated);

        return redirect()->route('admin.careers.index')->with('success', 'Job posted successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $job = Job::findOrFail($id);
        return view('includes.admin.careers.edit', compact('job'));
    }

    // Update the job
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'location' => 'nullable|string|max:255',
        ]);

        $job = Job::findOrFail($id);
        $job->update($validated);

        return redirect()->route('admin.careers.index')->with('success', 'Job updated successfully!');
    }

    // Delete a job
    public function destroy($id)
    {
        Job::destroy($id);
        return redirect()->route('admin.careers.index')->with('success', 'Job deleted successfully!');
    }



    public function send(Request $request)
    {
        // Validate the form
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'dob'            => 'required|date',
            'gender'         => 'required',
            'address'        => 'nullable|string|max:500',
            'pincode'        => 'nullable|string|max:10',
            'city'           => 'nullable|string|max:255',
            'mobile'         => 'required|string|max:15',
            'email'          => 'required|email|max:255',
            'total_exp'      => 'nullable|string|max:50',
            'qualification'  => 'required|string|max:255',
            'present_job'    => 'nullable|string|max:255',
            'current_ctc'    => 'nullable|string|max:50',
            'notice_period'  => 'nullable|string|max:50',
            'expected_ctc'   => 'required|string|max:50',
            'resume'         => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Handle File Upload
        $resumePath = $request->file('resume')->store('resumes');

        // Prepare Data for Email
        $data = $request->all();
        $data['resumePath'] = storage_path('app/' . $resumePath);

        // Send Email
        Mail::send('emails.job_mail', $data, function ($message) use ($data) {
            $message->to([
                'hr@dhw.co.in',
                'benedict@dhw.co.in',
                'nirmal@dhw.co.in',
                'dianaadigital2024@gmail.com'
                
            ])
            ->subject('New Job Application from ' . $data['first_name'] . ' ' . $data['last_name'])
            ->attach($data['resumePath']);
        });

        return back()->with('success', 'Your application has been sent successfully!');
    }

}
