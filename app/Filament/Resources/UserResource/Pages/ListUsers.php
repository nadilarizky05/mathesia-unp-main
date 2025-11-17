<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $user = Auth::user();

        // ✅ Jika user adalah TEACHER, tampilkan tabs berdasarkan KELAS
        if ($user->role === 'teacher') {
            return $this->getClassTabs();
        }

        // ✅ Jika user adalah ADMIN, tampilkan tabs berdasarkan ROLE
        return $this->getRoleTabs();
    }

    /**
     * Tabs untuk ADMIN: berdasarkan role (All, Admin, Teacher, Student)
     */
    protected function getRoleTabs(): array
    {
        $allCount = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $studentCount = User::where('role', 'student')->count();

        return [
            'all' => Tab::make('All Users')
                ->badge($allCount)
                ->badgeColor('success'),

            'admins' => Tab::make('Admins')
                ->badge($adminCount)
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'admin')),

            'teachers' => Tab::make('Teachers')
                ->badge($teacherCount)
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'teacher')),

            'students' => Tab::make('Students')
                ->badge($studentCount)
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('role', 'student')),
        ];
    }

    /**
     * Tabs untuk TEACHER: berdasarkan kelas siswa (All, 7A, 7B, 8A, dst)
     */
    protected function getClassTabs(): array
    {
        $user = Auth::user();

        // Ambil semua kelas yang ada di sekolah teacher (distinct & sorted)
        $classes = User::where('school', $user->school)
            ->where('role', 'student')
            ->whereNotNull('class')
            ->where('class', '!=', '')
            ->distinct()
            ->pluck('class')
            ->toArray();

        // Sort kelas secara natural (7A, 7B, 8A, 8B, dst)
        $classes = $this->sortClasses($classes);

        // Total semua siswa
        $totalStudents = User::where('school', $user->school)
            ->where('role', 'student')
            ->count();

        // Tab "All Students"
        $tabs = [
            'all' => Tab::make('All Students')
                ->badge($totalStudents)
                ->badgeColor('success'),
        ];

        // Tab untuk setiap kelas
        foreach ($classes as $class) {
            $count = User::where('school', $user->school)
                ->where('role', 'student')
                ->where('class', $class)
                ->count();

            $tabs[$class] = Tab::make($class)
                ->badge($count)
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('class', $class));
        }

        return $tabs;
    }

    /**
     * Helper: Sort kelas secara natural (7A, 7B, 8A, 8B, 9A, dst)
     */
    protected function sortClasses(array $classes): array
    {
        usort($classes, function($a, $b) {
            // Extract angka dan huruf dari kelas (misal: "7A" -> angka: 7, huruf: A)
            preg_match('/^(\d+)([A-Za-z]*)$/', $a, $matchA);
            preg_match('/^(\d+)([A-Za-z]*)$/', $b, $matchB);
            
            $numA = isset($matchA[1]) ? (int)$matchA[1] : 0;
            $numB = isset($matchB[1]) ? (int)$matchB[1] : 0;
            $letterA = isset($matchA[2]) ? strtoupper($matchA[2]) : '';
            $letterB = isset($matchB[2]) ? strtoupper($matchB[2]) : '';
            
            // Sort berdasarkan angka dulu, baru huruf
            if ($numA !== $numB) {
                return $numA - $numB;
            }
            
            return strcmp($letterA, $letterB);
        });
        
        return $classes;
    }
}