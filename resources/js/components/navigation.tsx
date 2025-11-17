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
                            {[
                                { path: '/topics', label: 'Learning Material' },
                                // {
                                //     path: '/learning-videos',
                                //     label: 'Learning Video',
                                // },
                                { path: '/tka', label: 'TKA' },
                                { path: '/our-team', label: 'Our Team' },
                            ].map((item) => (
                                <li key={item.path}>
                                    <Link
                                        href={item.path}
                                        className={`text-sm transition-colors lg:text-base ${
                                            isActive(item.path)
                                                ? 'border-b-2 border-[#2f6a62] font-extrabold text-[#2f6a62]'
                                                : 'font-medium text-gray-700 hover:text-[#2f6a62]'
                                        }`}
                                    >
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
                                        className="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50"
                                    >
                                        Profil Saya
                                    </Link>
                                    <button
                                        onClick={handleLogout}
                                        className="w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-red-50"
                                    >
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
                            <li>
                                <Link
                                    href={`/topics`}
                                    className={`block px-2 text-sm transition-colors ${
                                        isActive('/topics')
                                            ? 'font-semibold text-[#2f6a62]'
                                            : 'text-gray-700 hover:text-[#2f6a62]'
                                    }`}
                                >
                                    Learning Material
                                </Link>
                            </li>
                            {/* <li>
                                <Link
                                    href={`/learning-videos`}
                                    className={`block px-2 text-sm transition-colors ${
                                        isActive('/learning-videos')
                                            ? 'font-semibold text-[#2f6a62]'
                                            : 'text-gray-700 hover:text-[#2f6a62]'
                                    }`}
                                >
                                    Learning Video
                                </Link>
                            </li> */}
                            <li>
                                <Link
                                    href={`/tka`}
                                    className={`block px-2 text-sm transition-colors ${
                                        isActive('/tka')
                                            ? 'font-semibold text-[#2f6a62]'
                                            : 'text-gray-700 hover:text-[#2f6a62]'
                                    }`}
                                >
                                    TKA
                                </Link>
                            </li>
                            {/* ✅ TAMBAHKAN INI */}
                            <li>
                                <Link
                                    href={`/our-team`}
                                    className={`block px-2 text-sm transition-colors ${
                                        isActive('/our-team')
                                            ? 'font-semibold text-[#2f6a62]'
                                            : 'text-gray-700 hover:text-[#2f6a62]'
                                    }`}
                                >
                                    Our Team
                                </Link>
                            </li>
                        </ul>

                        {/* Divider */}
                        <div className="my-4 border-t border-gray-200" />

                        {/* User Section */}
                        <Link
                            href="/profile"
                            className="flex items-center gap-3 rounded-lg px-2 py-2 transition hover:bg-gray-100 active:bg-gray-200"
                        >
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
                        </Link>

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
