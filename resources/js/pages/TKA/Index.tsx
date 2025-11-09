import Navigation from '@/components/navigation';
import { router, usePage, Head, Link } from '@inertiajs/react';
import { useEffect } from 'react';
import { toast, Toaster } from 'react-hot-toast';
import Swal from 'sweetalert2';

interface Props {
    tka: { id: number; title: string; description: string };
    hasAttempt: boolean;
    latestAttempt?: { id: number };
    flash?: { success?: string; error?: string };
}

export default function Index() {
    const { props } = usePage<{
        tka: Props['tka'];
        hasAttempt: boolean;
        latestAttempt?: any;
        flash?: any;
    }>();
    const { tka, hasAttempt, latestAttempt, flash } = props;

    // Handle flash messages
    useEffect(() => {
        if (flash?.error) {
            toast.error(flash.error);
        }
        if (flash?.success) {
            toast.success(flash.success);
        }
    }, [flash]);

    const confirmStart = () => {
        Swal.fire({
            title: 'Mulai TKA?',
            text: 'Apakah Anda yakin ingin memulai TKA sekarang?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2f6a62',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Mulai!',
            cancelButtonText: 'Batal',
        }).then((res) => {
            if (res.isConfirmed) {
                router.post('/tka/start', {}, {
                    onSuccess: () => {
                    },
                    onError: (errors) => {
                        toast.error(errors.message || 'Gagal memulai TKA');
                    }
                });
            }
        });
    };

    const handleRetake = () => {
        Swal.fire({
            title: 'Tes Ulang?',
            text: 'Hasil sebelumnya akan tetap tersimpan. Yakin ingin mengulang tes?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#2f6a62',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Ulang!',
            cancelButtonText: 'Batal',
        }).then((res) => {
            if (res.isConfirmed) {
                router.post('/tka/start', 
                    { force_new: true },
                );
            }
        });
    };

    return (
        <>
            <Head title="TKA" />
            <Toaster position="top-center" />
            <Navigation />
            <div className="flex min-h-screen items-center justify-center bg-gradient-to-br from-[#e0eae8] to-[#f8faf9] px-4">
                <div className="w-full max-w-xl rounded-2xl border border-[#e0eae8] bg-white p-8 text-center shadow-xl">
                    <h1 className="mb-2 text-3xl font-bold text-gray-900">
                        Tes Kemampuan Akademik
                    </h1>
                    <p className="mb-8 text-gray-600">{tka.description}</p>

                    {hasAttempt ? (
                        <div>
                            <div className="mb-6">
                                <div className="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
                                    <svg
                                        className="h-10 w-10 text-green-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth={2.5}
                                            d="M9 12l2 2 4-4"
                                        />
                                    </svg>
                                </div>
                                <h2 className="text-2xl font-semibold text-gray-800">
                                    TKA Sudah Dikerjakan
                                </h2>
                                <p className="text-gray-600">
                                    Anda sudah menyelesaikan TKA ini.
                                </p>
                            </div>
                          <div className="flex flex-col gap-3">
                            <div className="flex gap-3">
                                <Link
                                    href={`/tka/result/${latestAttempt?.id}`}
                                    className="flex-1 text-center rounded-xl bg-yellow-500 px-6 py-3 font-semibold text-white hover:bg-yellow-600 transition-colors"
                                >
                                    Cek Hasil
                                </Link>
                                <button
                                    onClick={handleRetake}
                                    className="flex-1 rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white hover:bg-blue-700 transition-colors"
                                >
                                    Tes Ulang
                                </button>
                            </div>
                            <a
                                href='/'
                                className="text-center rounded-xl bg-[#2f6a62] px-6 py-3 font-semibold text-white hover:bg-[#25594f] transition-colors"
                            >
                                Kembali ke Dashboard
                            </a>
                        </div>
                        </div>
                    ) : (
                        <div>
                            <h3 className="mb-4 text-lg font-medium text-gray-800">
                                Instruksi:
                            </h3>
                            <ul className="mb-6 space-y-2 text-left text-sm text-gray-700">
                                <li>✅ Pastikan koneksi internet stabil</li>
                                <li>✅ Kerjakan semua soal dengan teliti</li>
                                <li>
                                    ✅ Jangan menutup halaman selama mengerjakan
                                </li>
                            </ul>

                            <button
                                onClick={confirmStart}
                                className="w-full rounded-xl bg-[#2f6a62] px-6 py-4 font-semibold text-white transition hover:bg-[#25594f]"
                            >
                                Mulai TKA
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </>
    );
}