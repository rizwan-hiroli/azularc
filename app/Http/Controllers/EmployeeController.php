<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * list all employees.
     *
     * @return void
     */
    public function index()
    {
        return Employee::latest()->paginate(10);
    }

    /**
     * submit all users.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'age' => 'required|integer',
            'email' => 'required|email|unique:employees,email',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|max:2048', // Optional, file validation
        ]);

        // Store the employee
        $employee = new Employee($validatedData);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->photo = $photoPath;
        }

        $employee->save();

        return response()->json($employee, 201); // 201 Created
    }

    /**
     * show single employee.
     *
     * @param [type] $id
     * @return void
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            return $employee;
        }

        return response()->json(['message' => 'Employee not found'], 404);
    }

    /**
     * Update existing employee.
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:100',
            'age' => 'required|integer',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'photo' => 'nullable|file|image|max:2048',
        ]);

        $employee->fill($validatedData);

        // Handle photo upload if provided
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $employee->photo = $photoPath;
        }

        $employee->save();

        return response()->json($employee, 200); // 200 OK
    }

    /**
     * Delete Employee.
     *
     * @param [type] $id
     * @return void
     */
    public function destroy($id)
    {
        $employee = Employee::find($id);

        if ($employee) {
            $employee->delete();
            return response()->json(['message' => 'Employee deleted'], 200);
        }

        return response()->json(['message' => 'Employee not found'], 404);
    }
}
