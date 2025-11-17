import CanvasAnswer from '@/components/CanvasAnswer';
import FinalTestInline from '@/components/FinalTestInline';
import { Link, usePage } from '@inertiajs/react';
import axios from 'axios';
import { motion } from 'framer-motion';
import {
    CheckCircle,
    ChevronLeft,
    ChevronRight,
    Home,
    Lock,
    Menu,
    X,
} from 'lucide-react';
import { useEffect, useMemo, useState } from 'react';
import toast from 'react-hot-toast';
import Swal from 'sweetalert2';

interface MaterialSection {
    id: number;
    order: number;
    title?: string;
    wacana?: string;
    masalah?: string;
    berpikir_soal_1?: string;
    berpikir_soal_2?: string;
    rencanakan?: string;
    selesaikan?: string;
    periksa?: string;
    kerjakan_1?: string;
    kerjakan_2?: string;
}

interface Material {
    id: number;
    title: string;
    level: string;
    video_url?: string;
    subtopic?: {
        id: number;
        title: string;
        topic?: { title: string };
    };
}

interface StudentProgress {
    active_section: number;
    completed_section: number[];
}

interface StudentAnswer {
    id: number;
    material_section_id: number;
    field_name: string;
    answer_text?: string;
    answer_file?: string;
    score?: number | null;
    feedback?: string | null;
    graded_at?: string | null;
    graded_by?: string | null;
}

interface Props {
    material: Material;
    sections: MaterialSection[];
    studentProgress?: StudentProgress;
    answers?: Record<number, StudentAnswer[]>;
}

// ✅ Komponen untuk Menampilkan Nilai & Feedback
const GradingDisplay = ({
    answer,
}: {
    answer: { score?: number | null; feedback?: string | null };
}) => {
    if (!answer.score && !answer.feedback) return null;

    const getScoreColor = (score: number) => {
        if (score >= 80) return 'text-green-300 font-bold';
        if (score >= 60) return 'text-yellow-300 font-bold';
        return 'text-red-300 font-bold';
    };

    return (
        <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.4 }}
            className="mt-3 mb-3 rounded-lg border-2 border-[rgb(47,106,98)] bg-gradient-to-br from-[rgb(47,106,98)] to-[rgb(34,80,73)] p-3 text-sm"
            style={{ fontFamily: '"Comic Sans MS", "Comic Sans", cursive' }}
        >
            {answer.score !== null && answer.score !== undefined && (
                <div className="mb-1">
                    <span className="text-white">
                        <strong>Nilai: </strong>
                    </span>
                    <span className={getScoreColor(answer.score)}>
                        {answer.score}/100
                    </span>
                </div>
            )}

            {answer.feedback && (
                <div>
                    <span className="text-white">
                        <strong>Feedback: </strong>
                    </span>
                    <span className="text-white">{answer.feedback}</span>
                </div>
            )}
        </motion.div>
    );
};

export default function Show() {
    const { material, sections, studentProgress, answers } = usePage()
        .props as unknown as Props;

    const totalSections = 1 + sections.length + 1;

    const [activeSection, setActiveSection] = useState<number>(
        studentProgress?.active_section ?? 1,
    );
    const [completedSections, setCompletedSections] = useState<number[]>(
        studentProgress?.completed_section ?? [],
    );

    const [showFinalTest, setShowFinalTest] = useState(false);
    const [finalTestData, setFinalTestData] = useState<any>(null);
    const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
    const [isLoadingFinalTest, setIsLoadingFinalTest] = useState(false);

    const [studentAnswers, setStudentAnswers] = useState<
        Record<
            string,
            {
                text?: string;
                file?: string | null;
                score?: number | null;
                feedback?: string | null;
                graded_at?: string | null;
                graded_by?: string | null;
            }
        >
    >({});

    // ✅ Load jawaban termasuk grading info
    useEffect(() => {
        if (answers) {
            const mapped: Record<
                string,
                {
                    text?: string;
                    file?: string | null;
                    score?: number | null;
                    feedback?: string | null;
                    graded_at?: string | null;
                    graded_by?: string | null;
                }
            > = {};
            Object.entries(answers).forEach(([sectionId, ans]) => {
                ans.forEach((a: StudentAnswer) => {
                    const key = `${sectionId}_${a.field_name}`;
                    mapped[key] = {
                        text: a.answer_text || '',
                        file: a.answer_file || null,
                        score: a.score ?? null,
                        feedback: a.feedback ?? null,
                        graded_at: a.graded_at ?? null,
                        graded_by: a.graded_by ?? null,
                    };
                });
            });
            setStudentAnswers(mapped);
        }
    }, [answers]);

    // ✅ Auto-load tes akhir jika sudah ada attempt sebelumnya
    useEffect(() => {
        const loadExistingTest = async () => {
            if (activeSection === totalSections && !finalTestData) {
                try {
                    // ✅ Gunakan GET untuk cek attempt tanpa membuat baru
                    const res = await fetch(
                        `/final-test/check/${material.id}`,
                        {
                            method: 'GET',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                        },
                    );

                    const data = await res.json();

                    // ✅ Hanya set finalTestData jika benar-benar sudah ada attempt
                    if (res.ok && data.hasAttempt && data.attempt) {
                        setFinalTestData(data);
                        console.log('✅ Existing test attempt loaded');
                    }
                } catch (err) {
                    // Silently fail - user can click "Mulai Tes Akhir" button
                    console.log('No existing test attempt found');
                }
            }
        };

        loadExistingTest();
    }, [activeSection, totalSections, material.id, finalTestData]);

    const progressPercent = Math.round(
        (completedSections.length / totalSections) * 100,
    );

    const handleStartFinalTest = async () => {
        // ✅ Cegah double click
        if (isLoadingFinalTest) return;

        setIsLoadingFinalTest(true);
        const loading = toast.loading('Memulai tes akhir...');

        try {
            const res = await fetch(`/final-test/start/${material.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        (
                            document.querySelector(
                                'meta[name="csrf-token"]',
                            ) as HTMLMetaElement
                        )?.content || '',
                },
            });

            const data = await res.json();

            if (!res.ok)
                throw new Error(data.message || 'Gagal memulai tes akhir');

            setFinalTestData(data);

            if (data.attempt?.is_submitted) {
                toast('Tes akhir ini sudah dikumpulkan sebelumnya.', {
                    icon: 'ℹ️',
                });
            } else {
                toast.success('✅ Tes akhir dimulai!');
            }
        } catch (err: any) {
            console.error('❌ Error memulai tes akhir:', err);
            toast.error(err.message || 'Gagal memulai tes akhir.');
        } finally {
            toast.dismiss(loading);
            setIsLoadingFinalTest(false);
        }
    };

    // ✅ PERBAIKAN: Simpan progress dengan active_section yang benar
    const saveProgress = async (
        completed: number[],
        currentSection?: number,
    ) => {
        try {
            await axios.post(`/materials/${material.id}/progress`, {
                active_section: currentSection ?? activeSection,
                completed_section: completed,
                is_completed: completed.length === totalSections,
            });

            console.log('✅ Progress berhasil disimpan!');
        } catch (error: any) {
            console.error(
                '❌ Gagal menyimpan progress:',
                error.response?.data || error,
            );
        }
    };

    const completeAndNext = async () => {
        const newCompleted = completedSections.includes(activeSection)
            ? completedSections
            : [...completedSections, activeSection];

        setCompletedSections(newCompleted);

        // ✅ Tentukan section berikutnya
        const nextSection =
            activeSection < totalSections ? activeSection + 1 : activeSection;

        // ✅ Simpan progress dengan section berikutnya
        await saveProgress(newCompleted, nextSection);

        if (
            newCompleted.length === totalSections &&
            completedSections.length < totalSections
        ) {
            Swal.fire({
                icon: 'success',
                title: '🎉 Selamat!',
                text: 'Kamu sudah menyelesaikan seluruh materi.',
                confirmButtonColor: '#2f6a62',
            });
        }

        if (activeSection < totalSections) {
            window.location.reload();
            window.scrollTo(0, 0);
        }
    };

    // ✅ FUNGSI PREVIOUS BUTTON - RELOAD SETELAH SAVE
    const goPrevious = () => {
        if (activeSection > 1) {
            const prevSection = activeSection - 1;
            saveProgress(completedSections, prevSection).then(() => {
                window.location.reload();
                window.scrollTo(0, 0);
            });
        }
    };

    // ✅ PERBAIKAN: Simpan progress saat manual navigation via sidebar
    const handleSectionChange = (sectionId: number) => {
        saveProgress(completedSections, sectionId).then(() => {
            window.location.reload();
            window.scrollTo(0, 0);
        });
    };

    const canAccessSection = (id: number) => {
        if (id === totalSections) {
            return completedSections.length >= totalSections - 1;
        }
        return id === 1 || completedSections.includes(id - 1);
    };

    const sidebarSections = useMemo(() => {
        const list = [{ id: 1, name: 'Section 1 - Video' }];
        const titleCount: Record<string, number> = {};

        sections.forEach((s, i) => {
            let displayName = s.title || `Section ${i + 2} - Materi`;

            if (s.title) {
                titleCount[s.title] = (titleCount[s.title] || 0) + 1;
                if (titleCount[s.title] > 1) {
                    displayName = `${s.title} - Kegiatan ${titleCount[s.title]}`;
                } else {
                    const duplicates = sections.filter(
                        (sec) => sec.title === s.title,
                    );
                    if (duplicates.length > 1) {
                        displayName = `${s.title} - Kegiatan 1`;
                    }
                }
            }

            list.push({
                id: i + 2,
                name: displayName,
            });
        });
        list.push({ id: sections.length + 2, name: '🧾 Tes Akhir' });
        return list;
    }, [sections]);

    const handleAnswerSubmit = async (
        sectionId: number,
        field: string,
        answerText: string,
        answerFile?: File | null,
    ) => {
        const formData = new FormData();
        formData.append('material_section_id', sectionId.toString());
        formData.append('field_name', field);
        if (answerText) formData.append('answer_text', answerText);
        if (answerFile) formData.append('answer_file', answerFile);

        try {
            const res = await axios.post('/student-answers', formData, {
                headers: { 'Content-Type': 'multipart/form-data' },
            });

            // ✅ Tambahkan timestamp untuk bypass cache
            const savedFile = res.data.data.answer_file
                ? `${res.data.data.answer_file}?t=${Date.now()}`
                : null;

            setStudentAnswers((prev) => ({
                ...prev,
                [`${sectionId}_${field}`]: {
                    text: answerText,
                    file: savedFile,
                    score: res.data.data.score ?? null,
                    feedback: res.data.data.feedback ?? null,
                    graded_at: res.data.data.graded_at ?? null,
                    graded_by: res.data.data.graded_by ?? null,
                },
            }));

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Jawaban berhasil disimpan!',
                timer: 2000,
                showConfirmButton: false,
            });
        } catch (error) {
            console.error('Gagal menyimpan jawaban:', error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: 'Gagal menyimpan jawaban',
                confirmButtonColor: '#2f6a62',
            });
        }
    };

    const renderSectionContent = (section: MaterialSection) => {
        const fields = [
            { key: 'wacana', label: 'Wacana', editable: false },
            { key: 'masalah', label: 'Masalah', editable: true },
            { key: 'berpikir_soal_1', label: 'Ayo Berpikir!', editable: true },
            { key: 'berpikir_soal_2', label: 'Ayo Berpikir!', editable: true },
            { key: 'rencanakan', label: 'Ayo Rencanakan!', editable: true },
            { key: 'selesaikan', label: 'Ayo Selesaikan!', editable: true },
            { key: 'periksa', label: 'Ayo Periksa Kembali!', editable: true },
            { key: 'kerjakan_1', label: 'Ayo Kerjakan!', editable: true },
            { key: 'kerjakan_2', label: 'Ayo Kerjakan!', editable: true },
        ];

        const decodeHTML = (html: string) => {
            const txt = document.createElement('textarea');
            txt.innerHTML = html;
            return txt.value;
        };

        return (
            <motion.div
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.3 }}
                className="rounded-2xl bg-white p-8 shadow-lg"
            >
                {fields.map(
                    (f) =>
                        section[f.key as keyof MaterialSection] && (
                            <div key={f.key} className="mb-10">
                                <div className="mb-4 inline-block rounded-2xl border-2 border-black bg-gradient-to-r from-cyan-100 to-blue-100 px-6 py-2 shadow-sm">
                                    <h3
                                        className="!mb-0 !text-lg font-bold text-gray-900"
                                        style={{
                                            fontFamily:
                                                '"Comic Sans MS", "Comic Sans", cursive',
                                        }}
                                    >
                                        {f.label}
                                    </h3>
                                </div>

                                {/* Soal Content */}
                                <div
                                    className="prose prose-img:rounded-xl rich-content mb-3 !text-gray-700"
                                    dangerouslySetInnerHTML={{
                                        __html: decodeHTML(
                                            section[
                                                f.key as keyof MaterialSection
                                            ] as string,
                                        ),
                                    }}
                                />

                                {/* Canvas Answer */}
                                {f.editable && (
                                    <>
                                        {/* ✅ Display Grading (Nilai & Feedback) */}
                                        {(() => {
                                            const answerKey = `${section.id}_${f.key}`;
                                            const currentAnswer =
                                                studentAnswers[answerKey];

                                            if (!currentAnswer) return null;

                                            return (
                                                <GradingDisplay
                                                    answer={currentAnswer}
                                                />
                                            );
                                        })()}
                                        <CanvasAnswer
                                            sectionId={section.id}
                                            fieldKey={f.key}
                                            existingImageUrl={
                                                studentAnswers[
                                                    `${section.id}_${f.key}`
                                                ]?.file || null
                                            }
                                            onSave={async (
                                                sectionId,
                                                field,
                                                imageFile,
                                            ) => {
                                                await handleAnswerSubmit(
                                                    sectionId,
                                                    field,
                                                    '',
                                                    imageFile,
                                                );
                                            }}
                                        />
                                    </>
                                )}
                            </div>
                        ),
                )}
            </motion.div>
        );
    };

    // ✅ Fungsi untuk mendapatkan judul section yang aktif
    const getActiveSectionTitle = () => {
        const activeItem = sidebarSections.find((s) => s.id === activeSection);
        return activeItem?.name || material.title;
    };

    const renderActiveSection = () => {
        if (activeSection === totalSections) {
            // ✅ Jika sudah ada finalTestData, langsung tampilkan
            if (finalTestData) {
                return (
                    <FinalTestInline
                        finalTest={finalTestData.finalTest}
                        attempt={finalTestData.attempt}
                        onSubmitSuccess={() => {
                            const newCompleted = [
                                ...new Set([
                                    ...completedSections,
                                    totalSections,
                                ]),
                            ];
                            setCompletedSections(newCompleted);
                            saveProgress(newCompleted);
                            setShowFinalTest(true);
                            Swal.fire({
                                icon: 'success',
                                title: '🎉 Tes Akhir Selesai!',
                                text: 'Progress 100%',
                                confirmButtonColor: '#2f6a62',
                            });
                        }}
                    />
                );
            }

            // ✅ Jika belum mulai, tampilkan tombol Mulai Tes Akhir
            return (
                <div className="rounded-2xl bg-white p-8 text-center shadow-lg">
                    <h2 className="mb-4 text-xl font-semibold text-gray-800">
                        Tes Akhir
                    </h2>
                    <p className="mb-6 text-gray-600">
                        Kamu telah menyelesaikan semua materi. Sekarang waktunya
                        mengerjakan tes akhir!
                    </p>
                    <button
                        onClick={handleStartFinalTest}
                        disabled={isLoadingFinalTest}
                        className="rounded-xl bg-[rgb(47,106,98)] px-6 py-3 font-semibold text-white transition-all hover:bg-green-900 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {isLoadingFinalTest ? 'Memuat...' : 'Mulai Tes Akhir'}
                    </button>
                </div>
            );
        }

        if (activeSection === 1) {
            return (
                <motion.div
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.3 }}
                    className="rounded-2xl bg-white p-8 shadow-lg"
                >
                    <h2 className="mb-6 text-xl font-bold text-gray-800">
                        Video Pembelajaran
                    </h2>
                    {material.video_url ? (
                        <div className="aspect-video w-full overflow-hidden rounded-xl">
                            <iframe
                                src={material.video_url}
                                className="h-full w-full"
                                allowFullScreen
                                title="Video Pembelajaran"
                            />
                        </div>
                    ) : (
                        <p className="text-center text-gray-500">
                            Video tidak tersedia
                        </p>
                    )}
                </motion.div>
            );
        }

        const section = sections[activeSection - 2];
        return renderSectionContent(section);
    };

    useEffect(() => {
        if (studentProgress && studentProgress.active_section > totalSections) {
            // Reset active_section ke totalSections (atau ke 1, sesuai kebutuhan)
            setActiveSection(totalSections);

            // Update ke backend juga agar database mengikuti
            axios.post(`/materials/${material.id}/progress`, {
                active_section: totalSections,
                completed_section: studentProgress.completed_section ?? [],
                is_completed: false,
            });
        }
    }, [totalSections]);

    return (
        <div
            className="flex min-h-screen bg-[#f8faf9]"
            style={{ fontFamily: 'Poppins, sans-serif' }}
        >
            {/* Mobile Menu Button */}
            <button
                onClick={() => setIsMobileMenuOpen(true)}
                className="fixed top-4 left-4 z-40 flex h-12 w-12 items-center justify-center rounded-full bg-[rgb(47,106,98)] text-white shadow-lg md:hidden"
            >
                <Menu className="h-6 w-6" />
            </button>

            {/* Mobile Sidebar Overlay */}
            {isMobileMenuOpen && (
                <div
                    className="fixed inset-0 z-50 bg-black/50 md:hidden"
                    onClick={() => setIsMobileMenuOpen(false)}
                />
            )}

            {/* Sidebar */}
            <aside
                className={`fixed top-0 z-50 flex h-screen w-72 flex-col bg-white shadow-xl transition-transform duration-300 md:sticky md:translate-x-0 ${isMobileMenuOpen ? 'translate-x-0' : '-translate-x-full'} `}
            >
                <button
                    onClick={() => setIsMobileMenuOpen(false)}
                    className="absolute top-4 right-4 md:hidden"
                >
                    <X className="h-6 w-6 text-gray-600" />
                </button>

                <div className="border-b bg-gradient-to-br from-[rgb(224,234,232)] to-white p-6 text-start">
                    <h2 className="text-base font-bold text-gray-800">
                        {material.subtopic?.topic?.title || 'Materi'}
                    </h2>
                    <p className="text-sm text-gray-500">
                        {material.title || 'Subtopik'}
                    </p>
                </div>

                <div className="px-6 pt-4">
                    <Link
                        href="/"
                        className="flex w-full items-center justify-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-5 py-3 text-white shadow-sm transition-colors hover:bg-[rgb(34,80,73)]"
                        style={{
                            fontFamily:
                                '"Comic Sans MS", "Comic Sans", cursive',
                        }}
                    >
                        <Home className="h-5 w-5" />
                        Kembali ke Dashboard
                    </Link>
                </div>

                <div className="border-b p-6">
                    <div className="mb-2 h-2 w-full rounded-full bg-gray-200">
                        <div
                            className="h-2 rounded-full bg-[rgb(47,106,98)] transition-all"
                            style={{ width: `${progressPercent}%` }}
                        />
                    </div>
                    <p className="text-start text-sm text-gray-600">
                        Progress: {completedSections.length}/{totalSections} (
                        {progressPercent}%)
                    </p>
                </div>

                <nav className="flex-1 overflow-y-auto p-6">
                    <h3 className="mb-3 text-start text-sm font-bold text-[rgb(47,106,98)] uppercase">
                        Section Materi
                    </h3>
                    <ul className="flex flex-col gap-2">
                        {sidebarSections.map((section) => {
                            const locked = !canAccessSection(section.id);
                            const completed = completedSections.includes(
                                section.id,
                            );
                            return (
                                <li key={section.id}>
                                    <button
                                        disabled={locked}
                                        onClick={() =>
                                            handleSectionChange(section.id)
                                        }
                                        className={`flex w-full items-center justify-between rounded-lg border px-4 py-3 text-start transition ${
                                            activeSection === section.id
                                                ? 'bg-black text-white'
                                                : locked
                                                  ? 'cursor-not-allowed bg-gray-100 text-gray-400'
                                                  : 'border-gray-200 bg-white text-gray-700 hover:bg-[rgb(224,234,232)]'
                                        }`}
                                    >
                                        <span className="text-sm">
                                            {section.name}
                                        </span>
                                        {completed ? (
                                            <CheckCircle className="h-4 w-4 text-green-500" />
                                        ) : locked ? (
                                            <Lock className="h-4 w-4" />
                                        ) : null}
                                    </button>
                                </li>
                            );
                        })}
                    </ul>
                </nav>
            </aside>

            {/* Main Content */}
            <main className="flex-1 overflow-y-auto px-4 py-8 md:px-8">
                <div className="mx-auto max-w-5xl">
                    {/* ✅ HEADER DENGAN JUDUL DINAMIS */}
                    <div className="mb-8 rounded-2xl bg-gradient-to-br from-[rgb(47,106,98)] to-[rgb(34,80,73)] p-6 shadow-lg">
                        <h3 className="text-center text-3xl font-bold text-white">
                            {getActiveSectionTitle()}
                        </h3>
                    </div>

                    {renderActiveSection()}

                    <div className="mt-8 flex justify-between">
                        <button
                            onClick={goPrevious}
                            disabled={activeSection === 1}
                            className="flex items-center gap-2 rounded-xl border bg-white px-5 py-2.5 text-gray-700 hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40"
                        >
                            <ChevronLeft /> Previous
                        </button>

                        {progressPercent === 100 &&
                        activeSection === totalSections &&
                        finalTestData?.attempt?.is_submitted ? (
                            <Link
                                href="/"
                                className="flex items-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-5 py-2.5 text-white hover:bg-green-900"
                            >
                                Kembali ke Dashboard
                            </Link>
                        ) : activeSection === totalSections ? (
                            <button
                                onClick={completeAndNext}
                                disabled={
                                    !finalTestData ||
                                    !finalTestData?.attempt?.is_submitted
                                }
                                className="flex items-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-5 py-2.5 text-white hover:bg-[rgb(34,80,73)] disabled:cursor-not-allowed disabled:opacity-40"
                            >
                                Finish
                                <ChevronRight />
                            </button>
                        ) : (
                            <button
                                onClick={completeAndNext}
                                className="flex items-center gap-2 rounded-xl bg-[rgb(47,106,98)] px-5 py-2.5 text-white hover:bg-[rgb(34,80,73)]"
                            >
                                Next Section
                                <ChevronRight />
                            </button>
                        )}
                    </div>
                </div>
            </main>
        </div>
    );
}
