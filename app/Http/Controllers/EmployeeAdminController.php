<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeAdminController extends Controller
{
    /**
     * List employees.
     *
     * @return void
     */
    public function index()
    {
        $employees = Employee::latest()->simplePaginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * show form to add new users.
     *
     * @return void
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store employee.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'email' => 'required|email|unique:employees,email',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $employee = new Employee($request->except('photo'));

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->photo = $photoPath;
        }

        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Employee added successfully!');
    }

    /**
     * Show existing employee.
     *
     * @param Employee $employee
     * @return void
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update existing employees.
     *
     * @param Request $request
     * @param Employee $employee
     * @return void
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $employee->fill($request->except('photo'));

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($employee->photo) {
                \Storage::disk('public')->delete($employee->photo);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->photo = $photoPath;
        }

        $employee->save();
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    /**
     * Delete existing employee.
     *
     * @param Employee $employee
     * @return void
     */
    public function destroy(Employee $employee)
    {
        // Delete photo if exists
        if ($employee->photo) {
            \Storage::disk('public')->delete($employee->photo);
        }

        $employee->delete();
        return redirect()->route('employees.index');
    }
}
