import Navigation from "@/components/navigation";
import { Link, usePage } from "@inertiajs/react";

interface Subtopic {
  id: number;
  title: string;
  description?: string;
  thumbnail?: string;
  level: 'inferior' | 'reguler' | 'superior';
  progress_percent: number;
}

export default function SubtopicsIndex() {
  const { topic, subtopics } = usePage().props as unknown as {
    topic: { id: number; title: string };
    subtopics: Subtopic[];
  };

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
    <div className="min-h-screen bg-[#f8faf9]" style={{ fontFamily: 'Poppins, sans-serif' }}>
      <Navigation />

      <main className="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div className="mb-10 text-center">
          <h1 className="text-3xl md:text-4xl font-bold text-gray-900">{topic.title}</h1>
          <p className="text-gray-600 mt-2">
            Belajar jadi makin seru! Pelajari materi sesuai level kekuatanmu!
          </p>
        </div>

        {subtopics.length > 0 ? (
          <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6">
            {subtopics.map((subtopic) => (
              <Link
                key={subtopic.id}
                href={`/subtopics/${subtopic.id}/game`}
                className="bg-white rounded-xl shadow hover:shadow-xl transition p-4 sm:p-5 flex flex-col relative"
              >
                {/* Badge Level di pojok kanan atas */}
                {/* <span
                  className={`absolute top-2 right-2 rounded-full border px-2 py-0.5 text-[10px] sm:text-xs font-semibold ${levelColor(
                    subtopic.level,
                  )}`}
                >
                  {subtopic.level.toUpperCase()}
                </span> */}

                {subtopic.thumbnail && (
                  <img
                    src={subtopic.thumbnail}
                    alt={subtopic.title}
                    className="rounded-lg w-full h-44 sm:h-56 object-cover mb-3 sm:mb-4"
                  />
                )}
                
                <h3 className="font-semibold text-gray-800 text-base sm:text-lg mb-2 sm:mb-3 line-clamp-2">
                  {subtopic.title}
                </h3>
                
                {/* Progress bar */}
                <div className="mt-auto pt-2">
                  <div className="w-full bg-gray-200 h-2 sm:h-2.5 rounded-full mb-2">
                    <div
                      className={`h-2 sm:h-2.5 rounded-full transition-all ${
                        subtopic.progress_percent >= 100
                          ? 'bg-green-500'
                          : subtopic.progress_percent >= 60
                          ? 'bg-yellow-400'
                          : 'bg-blue-400'
                      }`}
                      style={{ width: `${subtopic.progress_percent}%` }}
                    />
                  </div>
                  <p className="text-gray-500 text-xs sm:text-sm font-medium">
                    {subtopic.progress_percent}% completed
                  </p>
                </div>
              </Link>
            ))}
          </div>
        ) : (
          <div className="text-center py-12">
            <p className="text-gray-500 text-base">Belum ada subtopik untuk topik ini.</p>
          </div>
        )}
      </main>
    </div>
  );
}