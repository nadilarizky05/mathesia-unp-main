import Navigation from '@/components/navigation';
import { Link } from '@inertiajs/react';

interface Topic {
    id: number;
    title: string;
    description?: string;
    thumbnail_url?: string;
}

interface Props {
    topics: Topic[];
}

export default function Index({ topics }: Props) {
    return (
        <>
        <Navigation />
        <div className="min-h-screen bg-[#f8faf9]">
            <div className="mx-auto max-w-[1400px] px-4 py-10 sm:px-6 lg:px-8">
                <div className="mb-8 text-center">
                    <h1 className="text-3xl font-bold text-gray-900">
                        Learning Material
                    </h1>
                    <p className="mt-2 text-gray-600">
                        Belajar jadi makin seru! Pelajari materi sesuai level
                        kekuatanmu!
                    </p>
                </div>

                {topics.length === 0 ? (
                    <div className="py-20 text-center">
                        <p className="text-base text-gray-500">
                            Belum ada topik pembelajaran untuk saat ini.
                        </p>
                    </div>
                ) : (
                    <div className="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                        {topics.map((topic) => (
                            <Link
                                key={topic.id}
                                href={`/materials/${topic.id}`}
                                className="group overflow-hidden rounded-xl bg-white shadow transition-all hover:shadow-lg"
                            >
                                <div className="aspect-video w-full bg-gray-100">
                                    {topic.thumbnail_url ? (
                                        <img
                                            src={topic.thumbnail_url}
                                            alt={topic.title}
                                            className="h-full w-full object-cover transition-transform group-hover:scale-105"
                                        />
                                    ) : (
                                        <div className="flex h-full items-center justify-center text-sm text-gray-400">
                                            No Thumbnail
                                        </div>
                                    )}
                                </div>
                                <div className="p-4">
                                    <h2 className="text-sm font-semibold text-gray-900 sm:text-base">
                                        {topic.title}
                                    </h2>
                                    {topic.description && (
                                        <p className="mt-1 line-clamp-2 text-xs text-gray-500">
                                            {topic.description}
                                        </p>
                                    )}
                                </div>
                            </Link>
                        ))}
                    </div>
                )}
            </div>
        </div>
        </>

    );
}
