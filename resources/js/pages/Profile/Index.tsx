import Navigation from '@/components/navigation';
import { Head, router, usePage } from '@inertiajs/react';
import { AnimatePresence, motion } from 'framer-motion';
import {
    Eye,
    EyeOff,
    LogOut,
    Mail,
    PenBox,
    Shield,
    User,
    UserCircle,
    X,
} from 'lucide-react';
import { ChangeEvent, useState } from 'react';
import toast from 'react-hot-toast';

interface User {
    id: number;
    name: string;
    email: string;
    nis: number;
    avatar_url?: string | null;
    role?: string;
}

interface PageProps {
    auth: { user: User };
    [key: string]: any;
}

interface ProfileModalState {
    open: boolean;
    user: User | null;
}

export default function ProfilePage() {
    const { auth } = usePage<PageProps>().props;
    const user = auth.user;
    const [updateProfilModal, setUpdateProfilModal] =
        useState<ProfileModalState>({
            open: false,
            user: null,
        });

    const [form, setForm] = useState({
        name: user.name,
        email: user.email,
        nis: user.nis ?? '',
        password: '',
        newPassword: '',
        confirmPassword: '',
    });

    const [showPassword, setShowPassword] = useState(false);
    const [showNewPassword, setShowNewPassword] = useState(false);
    const [showConfirmPassword, setShowConfirmPassword] = useState(false);

    const [shake, setShake] = useState(false);

    const [passwordStrength, setPasswordStrength] = useState<
        'weak' | 'medium' | 'strong' | ''
    >('');
    const [confirmMatch, setConfirmMatch] = useState<boolean | null>(null);

    const handleLogout = () => router.post('/logout');

    const handleChange = (
        e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        const { name, value } = e.target;
        const updatedForm = { ...form, [name]: value };

        setForm(updatedForm);

        // Password Strength Check
        if (name === 'newPassword') {
            if (value.length < 6) {
                setPasswordStrength('weak');
            } else if (value.match(/[A-Z]/) && value.match(/[0-9]/)) {
                setPasswordStrength('strong');
            } else {
                setPasswordStrength('medium');
            }
        }

        // Confirm Password Match Check
        if (name === 'confirmPassword' || name === 'newPassword') {
            setConfirmMatch(
                updatedForm.newPassword === updatedForm.confirmPassword,
            );
        }
    };

    const handleUpdateProfile = async (e: React.FormEvent) => {
        e.preventDefault();

        router.post('/profile/update', form, {
            onSuccess: () => {
                toast.success('Profil berhasil diperbarui ✅');
                setUpdateProfilModal({ open: false, user: null });
            },
            onError: (errors) => {
                // Error dari validation (Laravel $request->validate)
                Object.values(errors).forEach((err) => {
                    toast.error(err as string);
                });
            },
        });
    };

    return (
        <div className="min-h-screen bg-gray-50">
            <Head title="Profil Saya" />
            <Navigation />

            <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.5 }}
                className="mx-auto max-w-4xl px-6 py-10"
            >
                <div className="flex flex-col items-center rounded-2xl bg-white p-8 text-center shadow-lg">
                    {/* Avatar */}
                    <div className="relative">
                        <div className="flex h-28 w-28 items-center justify-center rounded-full bg-[#2f6a62] text-4xl font-bold text-white">
                            {user.name.charAt(0).toUpperCase()}
                        </div>
                        {/* <button className="absolute bottom-0 right-0 bg-[#2f6a62] text-white p-2 rounded-full shadow hover:bg-[#245950] transition">
              <Edit size={16} />
            </button> */}
                    </div>

                    {/* User Info */}
                    <h1 className="mt-4 text-2xl font-semibold text-gray-800">
                        {user.name}
                    </h1>
                    {user.role && (
                        <p className="mt-1 text-sm text-gray-500 capitalize">
                            {user.role}
                        </p>
                    )}

                    <div className="mt-6 grid w-full grid-cols-1 gap-4 text-left sm:grid-cols-2">
                        <div className="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <User className="text-[#2f6a62]" />
                            <div>
                                <p className="text-sm text-gray-500">
                                    Nama Lengkap
                                </p>
                                <p className="font-medium text-gray-800">
                                    {user.name}
                                </p>
                            </div>
                        </div>
                        <div className="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <UserCircle className="text-[#2f6a62]" />
                            <div>
                                <p className="text-sm text-gray-500">NIS</p>
                                <p className="font-medium text-gray-800">
                                    {user.nis}
                                </p>
                            </div>
                        </div>

                        <div className="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <Mail className="text-[#2f6a62]" />
                            <div>
                                <p className="text-sm text-gray-500">Email</p>
                                <p className="font-medium text-gray-800">
                                    {user.email}
                                </p>
                            </div>
                        </div>

                        <div className="flex items-center gap-3 rounded-xl border border-gray-100 bg-gray-50 p-4">
                            <Shield className="text-[#2f6a62]" />
                            <div>
                                <p className="text-sm text-gray-500">Peran</p>
                                <p className="font-medium text-gray-800 capitalize">
                                    {user.role || 'Tidak diketahui'}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="mt-8 flex gap-2">
                        <button
                            onClick={() => {
                                setUpdateProfilModal({ open: true, user });
                            }}
                            className="flex items-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-5 py-2.5 text-white hover:bg-green-900"
                        >
                            <PenBox size={18} />
                            <span>Edit Profil</span>
                        </button>
                        <button
                            onClick={handleLogout}
                            className="flex items-center gap-2 rounded-xl bg-red-500 px-5 py-2.5 text-white transition hover:bg-red-600"
                        >
                            <LogOut size={18} />
                            <span>Keluar</span>
                        </button>
                    </div>
                </div>
                <AnimatePresence>
                    {updateProfilModal.open && (
                        <div className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
                            <motion.div
                                key="overlay"
                                initial={{ opacity: 0 }}
                                animate={{ opacity: 1 }}
                                exit={{ opacity: 0 }}
                                transition={{ duration: 0.25 }}
                                className="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
                            >
                                <motion.div
                                    key="modal"
                                    initial={{ scale: 0.8, opacity: 0 }}
                                    animate={{ scale: 1, opacity: 1 }}
                                    exit={{ scale: 0.8, opacity: 0 }}
                                    transition={{ duration: 0.3 }}
                                    className="relative w-[90%] max-w-lg rounded-xl bg-white p-6 shadow-xl"
                                >
                                    <button
                                        className="absolute top-3 right-3 text-gray-400 hover:text-gray-600"
                                        onClick={() =>
                                            setUpdateProfilModal({
                                                open: false,
                                                user: null,
                                            })
                                        }
                                    >
                                        <X size={19} />
                                    </button>

                                    <h2 className="mb-4 text-center text-xl font-bold text-gray-800">
                                        Update Profil
                                    </h2>

                                    <div className="flex flex-col gap-4">
                                        <div className='grid w-full grid-cols-1 gap-4 text-left sm:grid-cols-2'>
                                            <div>
                                                <label className="mb-1 block text-sm text-gray-700">
                                                    Nama Lengkap
                                                </label>
                                                <input
                                                    type="text"
                                                    name="name"
                                                    value={form.name}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                            </div>
                                            <div>
                                                <label className="mb-1 block text-sm text-gray-700">
                                                    NIS
                                                </label>
                                                <input
                                                    type="text"
                                                    name="nis"
                                                    value={form.nis}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                            </div>

                                            <div>
                                                <label className="mb-1 block text-sm text-gray-700">
                                                    Email
                                                </label>
                                                <input
                                                    type="email"
                                                    name="email"
                                                    value={form.email}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                            </div>
                                        </div>

                                        <hr className="border-gray-200" />

                                        <div>
                                            <label className="mb-1 block text-sm text-gray-700">
                                                Password Lama
                                            </label>
                                            <div className="relative">
                                                <input
                                                    type={
                                                        showPassword
                                                            ? 'text'
                                                            : 'password'
                                                    }
                                                    name="password"
                                                    value={form.password}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                                <button
                                                    type="button"
                                                    className="absolute top-2 right-3 text-gray-500 hover:text-gray-700"
                                                    onClick={() =>
                                                        setShowPassword(
                                                            !showPassword,
                                                        )
                                                    }
                                                >
                                                    {showPassword ? (
                                                        <EyeOff size={18} />
                                                    ) : (
                                                        <Eye size={18} />
                                                    )}
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <label className="mb-1 block text-sm text-gray-700">
                                                Password Baru
                                            </label>
                                            <div className="relative">
                                                <input
                                                    type={
                                                        showNewPassword
                                                            ? 'text'
                                                            : 'password'
                                                    }
                                                    name="newPassword"
                                                    value={form.newPassword}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                                {/* Progress Bar */}
                                                {form.newPassword.length >
                                                    0 && (
                                                    <div className="mt-2 h-2 w-full overflow-hidden rounded-full bg-gray-200">
                                                        <div
                                                            className={`h-full transition-all ${
                                                                passwordStrength ===
                                                                'weak'
                                                                    ? 'w-1/4 bg-red-500'
                                                                    : passwordStrength ===
                                                                        'medium'
                                                                      ? 'w-2/3 bg-yellow-500'
                                                                      : 'w-full bg-green-600'
                                                            }`}
                                                        ></div>
                                                    </div>
                                                )}

                                                {form.newPassword.length >
                                                    0 && (
                                                    <p
                                                        className={`mt-1 text-sm ${
                                                            passwordStrength ===
                                                            'weak'
                                                                ? 'text-red-500'
                                                                : passwordStrength ===
                                                                    'medium'
                                                                  ? 'text-yellow-500'
                                                                  : 'text-green-600'
                                                        }`}
                                                    >
                                                        {passwordStrength ===
                                                            'weak' &&
                                                            'Kekuatan Password: Lemah'}
                                                        {passwordStrength ===
                                                            'medium' &&
                                                            'Kekuatan Password: Cukup'}
                                                        {passwordStrength ===
                                                            'strong' &&
                                                            'Kekuatan Password: Kuat 🔥'}
                                                    </p>
                                                )}

                                                <button
                                                    type="button"
                                                    className="absolute top-2 right-3 text-gray-500 hover:text-gray-700"
                                                    onClick={() =>
                                                        setShowNewPassword(
                                                            !showNewPassword,
                                                        )
                                                    }
                                                >
                                                    {showNewPassword ? (
                                                        <EyeOff size={18} />
                                                    ) : (
                                                        <Eye size={18} />
                                                    )}
                                                </button>
                                            </div>
                                        </div>

                                        <div>
                                            <label className="mb-1 block text-sm text-gray-700">
                                                Konfirmasi Password Baru
                                            </label>
                                            <div className="relative">
                                                <input
                                                    type={
                                                        showConfirmPassword
                                                            ? 'text'
                                                            : 'password'
                                                    }
                                                    name="confirmPassword"
                                                    value={form.confirmPassword}
                                                    onChange={handleChange}
                                                    className="w-full rounded-lg border px-3 py-2 text-gray-900 focus:ring focus:ring-blue-200"
                                                />
                                                {confirmMatch !== null && (
                                                    <p
                                                        className={`mt-1 text-sm ${
                                                            confirmMatch
                                                                ? 'text-green-600'
                                                                : 'text-red-500'
                                                        }`}
                                                    >
                                                        {confirmMatch
                                                            ? 'Password Cocok ✅'
                                                            : 'Password Tidak Cocok ❌'}
                                                    </p>
                                                )}

                                                <button
                                                    type="button"
                                                    className="absolute top-2 right-3 text-gray-500 hover:text-gray-700"
                                                    onClick={() =>
                                                        setShowConfirmPassword(
                                                            !showConfirmPassword,
                                                        )
                                                    }
                                                >
                                                    {showConfirmPassword ? (
                                                        <EyeOff size={18} />
                                                    ) : (
                                                        <Eye size={18} />
                                                    )}
                                                </button>
                                            </div>
                                        </div>

                                        <button
                                            onClick={handleUpdateProfile}
                                            disabled={
                                                (form.newPassword.length > 0 &&
                                                    !confirmMatch) ||
                                                passwordStrength === 'weak'
                                            }
                                            className="mt-2 w-full rounded-lg   bg-[rgb(47,106,98)] hover:bg-green-900 py-2 text-white transition disabled:cursor-not-allowed disabled:bg-gray-400"
                                        >
                                            Simpan Perubahan
                                        </button>
                                    </div>
                                </motion.div>
                            </motion.div>
                        </div>
                    )}
                </AnimatePresence>
            </motion.div>
        </div>
    );
}
