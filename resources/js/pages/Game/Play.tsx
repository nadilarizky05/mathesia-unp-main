import { useForm, usePage, router } from '@inertiajs/react';
import { useState } from 'react';
import toast from 'react-hot-toast';
import Swal from 'sweetalert2';
import { GameComponents } from '@/pages/games';

interface GameProps {
    subtopic: {
        id: number;
        title: string;
        thumbnail?: string | null;
    };
    game_url?: string | null;
    level?: string;
}

export default function GamePlay() {
    const { subtopic, game_url, level } = usePage()
        .props as unknown as GameProps;
    const { data, setData, post, processing, errors, reset } = useForm({
        access_code: '',
    });
    const [loading, setLoading] = useState(false);

    //  const { subtopic, level } = usePage().props as GameProps;

    const GameComponent = GameComponents[subtopic.id] ?? null;

    const handleGenerateCode = (code: string, level: string) => {
        router.post(
            '/game/store-code',
            {
                sub_topic_id: subtopic.id,
                code,
                level: level.toLowerCase(), // sesuai database
            },
            {
                preserveScroll: true,
                onSuccess: () => toast.success("Kode berhasil disimpan!"),
                onError: () => toast.error("Gagal menyimpan kode."),
            },
        );
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);

        post(`/game/verify/${subtopic.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                setLoading(false);
                Swal.fire({
                    icon: 'success',
                    title: 'Kode Akses Terverifikasi! ✓',
                    text: 'Selamat! Kamu berhasil membuka akses materi baru.',
                    confirmButtonText: 'Mulai Belajar',
                    confirmButtonColor: 'rgb(47,106,98)',
                    customClass: {
                        popup: 'swal-poppins',
                    },
                }).then(() => {
                    toast.success('Kode berhasil diverifikasi!');
                });
            },
            onError: () => {
                setLoading(false);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errors.access_code || 'Kode tidak valid.',
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        popup: 'swal-poppins',
                    },
                });
                reset('access_code');
            },
        });
    };

    return (
        <div
            className="min-h-screen bg-[rgb(224,234,232)]"
            style={{ fontFamily: 'Poppins, sans-serif' }}
        >
            <main className="container mx-auto px-4 py-8 md:py-12">
                <h1 className="mb-8 text-center text-3xl font-bold text-[rgb(47,106,98)] md:mb-12 md:text-4xl">
                    Game Test - {subtopic.title}
                </h1>

                <div className="mx-auto grid max-w-6xl grid-cols-1 gap-6 lg:grid-cols-2 lg:gap-8">
                    {/* LEFT: Game Frame */}
                    <div className="flex items-center justify-center rounded-2xl bg-white p-4 shadow-lg md:p-6">
                        {GameComponent ? (
                            <GameComponent onCodeCreated={handleGenerateCode} level={level} />
                        ) : (
                            <div className="text-gray-400 italic">
                                Game untuk subtopik ini belum tersedia.
                            </div>
                        )}
                        {/* {game_url ? (
              <div className="w-full">
                <div className="w-full rounded-xl overflow-hidden border">
                  <iframe
                    src={game_url}
                    title={subtopic.title}
                    className="w-full h-[450px] md:h-[600px] rounded-xl"
                    sandbox="allow-scripts allow-forms allow-popups allow-popups-to-escape-sandbox allow-same-origin"
                    allowFullScreen
                  />
                </div>
                <p className="text-sm text-gray-500 mt-2 text-center">
                  Jika website tidak muncul, buka di tab baru:&nbsp;
                  <a
                    href={game_url}
                    target="_blank"
                    rel="noopener noreferrer"
                    className="text-[rgb(47,106,98)] underline"
                  >
                    Buka di tab baru
                  </a>
                </p>
              </div>
            ) : subtopic.thumbnail ? (
              <img
                src={subtopic.thumbnail}
                alt={subtopic.title}
                className="rounded-xl w-full max-h-[450px] object-cover"
              />
            ) : (
              <div className="text-gray-400 italic">Tidak ada game yang tersedia</div>
            )} */}
                    </div>

                    {/* RIGHT: Info + Code Input */}
                    <div className="flex flex-col gap-6">
                        <div className="rounded-2xl bg-white p-6 shadow-lg md:p-8">
                            <p className="mb-6 text-center leading-relaxed text-gray-700">
                                Sebelum mulai belajar, selesaikan game tes
                                berikut untuk menentukan kategori materi belajar
                                kamu. Setelah itu, masukkan{' '}
                                <b className="text-[rgb(47,106,98)]">
                                    6 kode unik
                                </b>{' '}
                                dari tantangan game tersebut.
                            </p>
                        </div>

                        <div className="rounded-2xl bg-white p-6 shadow-lg md:p-8">
                            <form onSubmit={handleSubmit}>
                                <h3 className="mb-4 text-center text-2xl font-bold text-[rgb(47,106,98)]">
                                    Masukkan Codenya disini
                                </h3>

                                <input
                                    type="text"
                                    maxLength={6}
                                    value={data.access_code.toUpperCase()}
                                    onChange={(e) =>
                                        setData(
                                            'access_code',
                                            e.target.value.toUpperCase(),
                                        )
                                    }
                                    className="focus:ring-opacity-20 w-full rounded-lg border-2 border-gray-300 px-4 py-3 text-center text-lg font-semibold tracking-wider text-gray-800 uppercase transition-all outline-none focus:border-[rgb(47,106,98)] focus:ring-2 focus:ring-[rgb(47,106,98)]"
                                    required
                                />

                                {errors.access_code && (
                                    <p className="mt-2 text-center text-sm text-red-500">
                                        {errors.access_code}
                                    </p>
                                )}

                                <button
                                    type="submit"
                                    disabled={processing || loading}
                                    className="mt-6 w-full transform rounded-full bg-[rgb(47,106,98)] px-6 py-3 font-semibold text-white shadow-md transition-all duration-300 hover:scale-105 hover:bg-[rgb(37,86,78)] disabled:cursor-not-allowed disabled:opacity-50"
                                >
                                    {loading ? 'Memproses...' : 'Cek Hasil Tes'}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {/* Back Button */}
                <div className="mt-8 text-center">
                    <a
                        href="/topics"
                        className="inline-flex items-center font-medium text-[rgb(47,106,98)] transition-colors duration-300 hover:text-[rgb(37,86,78)]"
                    >
                        <svg
                            className="mr-2 h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>
                        Kembali ke Learning Material
                    </a>
                </div>
            </main>

            <style>{`
        .swal-poppins {
          font-family: 'Poppins', sans-serif !important;
        }
      `}</style>
        </div>
    );
}
