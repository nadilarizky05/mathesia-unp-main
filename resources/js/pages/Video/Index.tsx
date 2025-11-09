import { Head, usePage } from '@inertiajs/react';
import toast, { Toaster } from 'react-hot-toast';
import React, { useState, useMemo } from 'react';
import Navigation from '@/components/navigation';
import { motion } from 'framer-motion';
import { Search } from 'lucide-react';

interface Video {
  id: number;
  title: string;
  video_url: string;
  level: string;
  order: number;
}

interface PageProps {
  [key: string]: any;
  videos: Video[];
}

export default function LearningVideoIndex() {
  const { props } = usePage<PageProps>();
  const { videos } = props;
  const [search, setSearch] = useState('');

  // Filter berdasarkan pencarian
  const filteredVideos = useMemo(() => {
    return videos.filter((v) =>
      v.title.toLowerCase().includes(search.toLowerCase())
    );
  }, [videos, search]);

  return (
    <div className="min-h-screen bg-gray-50">
      <Head title="Learning Videos" />
      <Toaster position="top-right" />
      <Navigation />

      <div className="max-w-6xl mx-auto px-4 py-10">
        {/* Header */}
        <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
          <h1 className="text-3xl font-extrabold text-[#2f6a62] tracking-tight sm:items-center">
            🎥 Learning Videos
          </h1>

          {/* Search Bar */}
          <div className="relative w-full sm:w-72">
            <Search className="absolute left-3 top-2.5 text-gray-800 w-5 h-5" />
            <input
              type="text"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Cari video..."
              className="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#2f6a62] focus:outline-none transition text-gray-800"
            />
          </div>
        </div>

        {/* Grid Video */}
        {filteredVideos.length === 0 ? (
          <div className="bg-white shadow rounded-xl p-6 text-center text-gray-500">
            Tidak ada video yang cocok dengan pencarian.
          </div>
        ) : (
          <div className="grid gap-8 md:grid-cols-2">
            {filteredVideos.map((video, index) => (
              <motion.div
                key={video.id}
                initial={{ opacity: 0, y: 30 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.05 }}
                className="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden border border-gray-100"
              >
                <div className="aspect-video bg-black">
                  <iframe
                    className="w-full h-full"
                    src={video.video_url}
                    title={video.title}
                    allowFullScreen
                  ></iframe>
                </div>
                <div className="p-5">
                  <h2 className="text-lg font-semibold text-gray-800 line-clamp-1">
                    {video.title}
                  </h2>
                  <p className="text-sm text-gray-500 mt-1">
                    Level:{' '}
                    <span className="capitalize font-medium text-[#2f6a62]">
                      {video.level}
                    </span>
                  </p>
                </div>
              </motion.div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
