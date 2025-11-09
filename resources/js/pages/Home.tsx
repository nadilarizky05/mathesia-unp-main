import Navigation from '@/components/navigation';
import { usePage, Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { CheckCircle, Clock, Gamepad2 } from 'lucide-react';

interface ProgressItem {
    id: number;
    sub_topic: {
        id: number;
        title: string;
    };
    material?: {
        id: number;
        title: string;
    } | null;
    game_code?: {
        id: number;
        code: string;
    } | null;
    level: 'inferior' | 'reguler' | 'superior';
    progress_percent: number;
    completed_at?: string | null;
}

interface Props {
    studentProgress: ProgressItem[];
    [key: string]: any;
}

export default function Home() {
    const { studentProgress = [] } = usePage<Props>().props;

    const levelColor = (level: string) => {
        switch (level) {
            case 'inferior':
                return 'bg-blue-100 text-blue-800 border-blue-300';
            case 'reguler':
                return 'bg-yellow-100 text-yellow-800 border-yellow-300';
            case 'superior':
                return 'bg-green-100 text-green-800 border-green-300';
            default:
                return 'bg-gray-100 text-gray-800 border-gray-300';
        }
    };

    return (
        <div className="min-h-screen bg-[#f8faf9]">
            <Navigation />

            <div className="mx-auto max-w-6xl px-6 py-10">
                {/* Panduan Penggunaan Website Section */}
                <motion.div
                    className="mb-12"
                    initial={{ opacity: 0, y: -10 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.4 }}
                >
                    <div className="animate-fade-in mb-8 text-center">
                        <h1 className="mb-2 text-3xl font-bold text-gray-900">
                            Panduan Penggunaan Website
                        </h1>
                        <div className="mx-auto mb-6 h-1 w-24 bg-gradient-to-r from-transparent via-[#2f6a62] to-transparent"></div>
                    </div>
                    
                    {/* Video Container */}
                    <div className="w-full overflow-hidden rounded-2xl shadow-lg" style={{ aspectRatio: '16/9' }}>
                        <iframe 
                            className="w-full h-full"
                            src="https://www.youtube.com/embed/YOUR_VIDEO_ID" 
                            title="Panduan Penggunaan Website" 
                            frameBorder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowFullScreen>
                        </iframe>
                    </div>
                </motion.div>

                {/* Progress Belajar Siswa Section */}
                <motion.div
                    initial={{ opacity: 0, y: -10 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.4, delay: 0.2 }}
                >
                    <div className="animate-fade-in mb-8 text-center">
                        <h1 className="mb-2 text-3xl font-bold text-gray-900">
                            Progress Belajar Siswa
                        </h1>
                        <div className="mx-auto mb-3 h-1 w-24 bg-gradient-to-r from-transparent via-[#2f6a62] to-transparent"></div>
                    </div>
                </motion.div>

                {studentProgress.length === 0 ? (
                    <motion.div
                        className="rounded-xl border bg-white p-6 text-center text-gray-600 shadow-sm"
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                    >
                        Belum ada data progress siswa.
                    </motion.div>
                ) : (
                    <div className="grid gap-6 sm:grid-cols-1 md:grid-cols-2">
                        {studentProgress.map((progress, i) => (
                            <motion.div
                                key={progress.id}
                                initial={{ opacity: 0, y: 30 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: i * 0.05 }}
                            >
                                <Link
                                    href={progress.material ? `/materials/${progress.material.id}` : '#'}
                                    className={`block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-md transition-all duration-300 hover:shadow-xl ${progress.material ? 'cursor-pointer hover:-translate-y-1' : 'cursor-not-allowed opacity-75'}`}
                                >
                                    <div className="p-6">
                                        {/* Header */}
                                        <div className="mb-3 flex items-center justify-between">
                                            <h2 className="text-lg font-semibold text-gray-800">
                                                {progress.sub_topic.title}
                                            </h2>

                                            <span
                                                className={`rounded-full border px-3 py-1 text-xs font-semibold ${levelColor(
                                                    progress.level,
                                                )}`}
                                            >
                                                {progress.level.toUpperCase()}
                                            </span>
                                        </div>

                                        {/* Game Code Info */}
                                        {progress.game_code && (
                                            <div className="mb-3 flex items-center gap-2 text-sm text-gray-600">
                                                <Gamepad2 className="h-4 w-4 text-[#2f6a62]" />
                                                <span>
                                                    Kode Game:{' '}
                                                    {progress.game_code.code}
                                                </span>
                                            </div>
                                        )}

                                        {/* Progress Bar */}
                                        <div className="relative mb-4 h-3 w-full overflow-hidden rounded-full bg-gray-200">
                                            <motion.div
                                                className={`absolute top-0 left-0 h-full rounded-full ${
                                                    progress.progress_percent >= 100
                                                        ? 'bg-green-500'
                                                        : progress.progress_percent >= 60
                                                        ? 'bg-yellow-400'
                                                        : 'bg-blue-400'
                                                }`}
                                                initial={{ width: 0 }}
                                                animate={{
                                                    width: `${progress.progress_percent}%`,
                                                }}
                                                transition={{
                                                    duration: 1,
                                                    ease: 'easeOut',
                                                }}
                                            />
                                        </div>

                                        {/* Status */}
                                        <div className="flex items-center justify-between text-sm">
                                            {progress.completed_at || progress.progress_percent >= 100 ? (
                                                <motion.div
                                                    className="flex items-center gap-2 text-green-600"
                                                    initial={{ opacity: 0 }}
                                                    animate={{ opacity: 1 }}
                                                    transition={{ delay: 0.3 }}
                                                >
                                                    <CheckCircle className="h-4 w-4" />
                                                    <span>
                                                        {progress.completed_at 
                                                            ? `Selesai pada ${new Date(progress.completed_at).toLocaleDateString('id-ID')}`
                                                            : 'Selesai'
                                                        }
                                                    </span>
                                                </motion.div>
                                            ) : (
                                                <div className="flex items-center gap-2 text-gray-500">
                                                    <Clock className="h-4 w-4" />
                                                    <span>Belum selesai</span>
                                                </div>
                                            )}

                                            <span className="text-gray-400">
                                                {progress.progress_percent}% progress
                                            </span>
                                        </div>
                                    </div>

                                    {/* Decorative footer gradient */}
                                    <div
                                        className={`h-1 ${
                                            progress.progress_percent >= 100
                                                ? 'bg-gradient-to-r from-green-400 to-green-600'
                                                : progress.progress_percent >= 60
                                                ? 'bg-gradient-to-r from-yellow-300 to-yellow-500'
                                                : 'bg-gradient-to-r from-blue-300 to-blue-500'
                                        }`}
                                    />
                                </Link>
                            </motion.div>
                        ))}
                    </div>
                )}

                <motion.div
                    className="mt-12 flex justify-center"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.5, delay: 0.3 }}
                >
                    <Link
                        href="/topics"
                        className="inline-flex items-center justify-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-8 py-3.5 text-base font-semibold text-white shadow-lg transition-all duration-300 hover:bg-[rgb(34,80,73)] hover:shadow-xl"
                    >
                        Lanjut Belajar
                    </Link>
                </motion.div>
            </div>
        </div>
    );
}