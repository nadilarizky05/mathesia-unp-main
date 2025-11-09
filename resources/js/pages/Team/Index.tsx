import React from "react";
import { Head, usePage } from "@inertiajs/react";
import Navigation from "@/components/navigation";

interface Member {
  id: number;
  name: string;
  role?: string;
  avatar_url?: string | null;
}

interface Team {
  id: number;
  name: string;
  members: Member[];
}

export default function About() {
  const { props } = usePage<{ teams: Team[] }>();
  const teams = props.teams || [];
  
  // Sort teams by id (ascending) - first input will have lowest id
  const sortedTeams = [...teams].sort((a, b) => a.id - b.id);

  return (
    <>
      <Head title="Tentang Kami" />
      <div className="min-h-screen bg-gray-50">
        <Navigation />
        
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
          {/* Header */}
          <div className="text-center mb-12">
            <h1 className="text-4xl font-bold text-gray-900 mb-4">
              Tentang Kami
            </h1>
          </div>

          {/* Daftar Tim */}
          {sortedTeams.map((team) => {
            // Sort members by id (ascending) - first input will have lowest id
            const sortedMembers = [...team.members].sort((a, b) => a.id - b.id);
            
            return (
              <div key={team.id} className="mb-12">
                <h2 className="text-2xl font-bold text-gray-800 mb-6">
                  {team.name}
                </h2>
                
                {/* Grid anggota - Mobile: 2 kolom, Desktop: max 5 kolom */}
                <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                  {sortedMembers.length === 0 ? (
                    <div className="col-span-full text-center py-8 text-gray-500">
                      Belum ada anggota.
                    </div>
                  ) : (
                    sortedMembers.map((member) => (
                      <div
                        key={member.id}
                        className="relative aspect-square rounded-lg overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
                      >
                        {member.avatar_url ? (
                          <img
                            src={member.avatar_url}
                            alt={member.name}
                            className="w-full h-full object-cover"
                          />
                        ) : (
                          <div className="w-full h-full bg-gray-300 flex items-center justify-center">
                            <span className="text-gray-400 text-4xl font-light">
                              No Image
                            </span>
                          </div>
                        )}
                        
                        {/* Overlay gradasi dan teks */}
                        <div className="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent">
                          <div className="absolute bottom-0 left-0 right-0 p-3">
                            <p className="text-white font-semibold text-sm">
                              {member.name}
                            </p>
                            {member.role && (
                              <p className="text-white/80 text-xs mt-1">
                                {member.role}
                              </p>
                            )}
                          </div>
                        </div>
                      </div>
                    ))
                  )}
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </>
  );
}