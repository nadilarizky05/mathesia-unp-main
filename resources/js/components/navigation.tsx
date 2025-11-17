import { Link, router, usePage } from '@inertiajs/react';
import { useEffect, useRef, useState } from 'react';

interface User {
    id: number;
    name: string;
    email: string;
    avatar_url?: string | null;
    role?: string;
}

interface PageProps {
    [key: string]: any;
    auth?: { user?: User };
    user?: User;
}

export default function Navigation() {
    const { props } = usePage<PageProps>();
    const user: User = props.auth?.user ||
        props.user || { id: 0, name: 'Guest', email: '', avatar_url: null };
    const [isDropdownOpen, setDropdownOpen] = useState(false);
    const [isMobileOpen, setMobileOpen] = useState(false);
    const dropdownRef = useRef<HTMLDivElement | null>(null);

    // Tutup dropdown jika klik di luar
    useEffect(() => {
        function handleClickOutside(event: MouseEvent) {
            if (
                dropdownRef.current &&
                !dropdownRef.current.contains(event.target as Node)
            ) {
                setDropdownOpen(false);
            }
        }
        document.addEventListener('mousedown', handleClickOutside);
        return () =>
            document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    const currentPath =
        typeof window !== 'undefined' ? window.location.pathname : '';

    const isActive = (path: string) => currentPath.startsWith(path);
    const handleLogout = () => router.post('/logout');
    const getInitial = (name: string) => name.charAt(0).toUpperCase();

    // Menu items dengan icon
    const menuItems = [
        {
            path: '/topics',
            label: 'Learning Material',
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
                    />
                </svg>
            ),
        },
        {
            path: '/tka',
            label: 'TKA',
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"
                    />
                </svg>
            ),
        },
        {
            path: '/our-team',
            label: 'Our Team',
            icon: (
                <svg
                    className="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        strokeLinecap="round"
                        strokeLinejoin="round"
                        strokeWidth="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    />
                </svg>
            ),
        },
    ];

    return (
        <nav id="nav-auth" className="sticky top-0 z-50 bg-white shadow-sm">
            <div className="mx-auto max-w-[1400px] px-4 sm:px-6 lg:px-8">
                <div className="flex h-16 items-center justify-between md:h-20">
                    {/* Logo & Navigation */}
                    <div className="flex items-center gap-8 lg:gap-12">
                        <Link href="/" className="flex-shrink-0">
                            <img
                                src="/assets/images/logos/logo.png"
                                className="h-8 md:h-10"
                                alt="logo"
                            />
                        </Link>

                        {/* Desktop Menu */}
                        <ul className="hidden items-center gap-6 md:flex lg:gap-8">
                            {menuItems.map((item) => (
                                <li key={item.path}>
                                    <Link
                                        href={item.path}
                                        className={`flex items-center gap-2 text-sm transition-colors lg:text-base ${
                                            isActive(item.path)
                                                ? 'border-b-2 border-[#2f6a62] font-extrabold text-[#2f6a62]'
                                                : 'font-medium text-gray-700 hover:text-[#2f6a62]'
                                        }`}
                                    >
                                        {item.icon}
                                        {item.label}
                                    </Link>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* User Profile & Mobile Menu Button */}
                    <div className="relative flex items-center gap-3">
                        {/* User Dropdown */}
                        <div className="hidden md:block" ref={dropdownRef}>
                            <button
                                onClick={() => setDropdownOpen(!isDropdownOpen)}
                                className="flex items-center gap-3 rounded-full px-3 py-2 transition hover:bg-gray-100"
                            >
                                {/* Badge dengan inisial */}
                                <div className="flex h-9 w-9 items-center justify-center rounded-full bg-[#2f6a62] font-semibold text-white">
                                    {getInitial(user.name)}
                                </div>
                                <div className="flex flex-col text-left">
                                    <span className="leading-tight font-medium text-gray-800">
                                        {user.name}
                                    </span>
                                    {user.role && (
                                        <span className="text-xs text-gray-500 capitalize">
                                            {user.role}
                                        </span>
                                    )}
                                </div>

                                <svg
                                    className={`h-4 w-4 text-gray-500 transition-transform ${
                                        isDropdownOpen ? 'rotate-180' : ''
                                    }`}
                                    fill="none"
                                    stroke="currentColor"
                                    strokeWidth="2"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>

                            {/* Dropdown Menu */}
                            {isDropdownOpen && (
                                <div className="animate-fadeIn absolute right-0 z-50 mt-2 w-44 rounded-xl border border-gray-100 bg-white py-2 shadow-lg">
                                    <Link
                                        href="/profile"
                                        className="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        <svg
                                            className="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                            />
                                        </svg>
                                        Profil Saya
                                    </Link>
                                    <button
                                        onClick={handleLogout}
                                        className="flex w-full items-center gap-2 px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                                    >
                                        <svg
                                            className="h-4 w-4"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                strokeLinecap="round"
                                                strokeLinejoin="round"
                                                strokeWidth="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"
                                            />
                                        </svg>
                                        Logout
                                    </button>
                                </div>
                            )}
                        </div>

                        {/* Mobile Toggle */}
                        <button
                            onClick={() => setMobileOpen(!isMobileOpen)}
                            className="p-2 text-gray-600 transition-colors hover:text-[#2f6a62] md:hidden"
                        >
                            {isMobileOpen ? (
                                <svg
                                    className="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            ) : (
                                <svg
                                    className="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                </svg>
                            )}
                        </button>
                    </div>
                </div>

                {/* Mobile Menu */}
                {isMobileOpen && (
                    <div className="border-t border-gray-100 bg-white py-5 shadow-inner md:hidden">
                        {/* Navigation Links */}
                        <ul className="mb-5 space-y-3">
                            {menuItems.map((item) => (
                                <li key={item.path}>
                                    <Link
                                        href={item.path}
                                        className={`flex items-center gap-3 px-2 text-sm transition-colors ${
                                            isActive(item.path)
                                                ? 'font-semibold text-[#2f6a62]'
                                                : 'text-gray-700 hover:text-[#2f6a62]'
                                        }`}
                                    >
                                        {item.icon}
                                        {item.label}
                                    </Link>
                                </li>
                            ))}
                        </ul>

                        {/* Divider */}
                        <div className="my-4 border-t border-gray-200" />

                        {/* User Section */}
                        <div className="flex items-center gap-3 px-2">
                            <div className="flex h-10 w-10 items-center justify-center rounded-full bg-[#2f6a62] text-lg font-semibold text-white shadow">
                                {getInitial(user.name)}
                            </div>

                            <div className="flex flex-col text-left">
                                <span className="leading-tight font-medium text-gray-800">
                                    {user.name}
                                </span>
                                {user.role && (
                                    <span className="text-xs text-gray-500 capitalize">
                                        {user.role}
                                    </span>
                                )}
                            </div>
                        </div>

                        {/* Logout Button */}
                        <div className="mt-5 px-2">
                            <button
                                onClick={handleLogout}
                                className="flex w-full items-center justify-center gap-2 rounded-xl border border-red-100 bg-red-50 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-100"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    className="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    strokeWidth={2}
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H7a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v1"
                                    />
                                </svg>
                                Logout
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </nav>
    );
}