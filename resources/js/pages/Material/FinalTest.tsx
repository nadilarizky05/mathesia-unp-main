import { router } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';

export interface FinalTestProps {
    finalTest: {
        id: number;
        title: string;
        duration_minutes: number;
        questions: {
            id: number;
            question: string;
            max_score: number;
        }[];
    };
    attempt: {
        id: number;
        student_id: number;
        material_id: number;
        started_at: string;
        expires_at: string;
        is_submitted: boolean;
        answers: {
            id: number;
            question_id: number;
            answer_text?: string;
            answer_file?: string;
        }[];
    };
    onSubmitSuccess?: () => void;
}

const FinalTest: React.FC<FinalTestProps> = ({
    finalTest,
    attempt,
    onSubmitSuccess,
}) => {
    const [answers, setAnswers] = useState<Record<number, any>>(() => {
        const map: Record<number, any> = {};
        attempt.answers?.forEach((ans) => {
            map[ans.question_id] = ans;
        });
        return map;
    });

    const [timeLeft, setTimeLeft] = useState<number>(0);
    const [submitting, setSubmitting] = useState(false);

    // 🕒 Timer
    useEffect(() => {
        if (attempt.is_submitted) return;

        const expiry = new Date(attempt.started_at).getTime() +
            finalTest.duration_minutes * 60 * 1000;

        const interval = setInterval(() => {
            const diff = Math.max(0, Math.floor((expiry - Date.now()) / 1000));
            setTimeLeft(diff);
            if (diff <= 0) {
                clearInterval(interval);
                handleSubmit(true);
            }
        }, 1000);

        return () => clearInterval(interval);
    }, [attempt.started_at, finalTest.duration_minutes]);

    const formatTime = (seconds: number) => {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        return `${m}:${s.toString().padStart(2, '0')}`;
    };

    const handleTextChange = (questionId: number, text: string) => {
        setAnswers((prev) => ({
            ...prev,
            [questionId]: { ...prev[questionId], answer_text: text },
        }));
    };

    const handleSaveAnswer = (questionId: number) => {
        const data = { answer_text: answers[questionId]?.answer_text || '' };
        router.post(`/final-test/save-answer/${attempt.id}/${questionId}`, data, {
            onSuccess: () => alert('💾 Jawaban disimpan'),
            onError: () => alert('❌ Gagal menyimpan jawaban'),
        });
    };

    const handleFileChange = (questionId: number, file: File) => {
        const formData = new FormData();
        formData.append('answer_file', file);

        router.post(`/final-test/save-answer/${attempt.id}/${questionId}`, formData, {
            forceFormData: true,
            onSuccess: () => alert('✅ File berhasil diunggah!'),
            onError: () => alert('❌ Gagal upload file.'),
        });
    };

    const handleSubmit = (auto = false) => {
        if (!auto && !confirm('Yakin ingin mengirim semua jawaban?')) return;
        setSubmitting(true);
        router.post(`/final-test/submit/${attempt.id}`, {}, {
            onSuccess: () => {
                alert(auto ? '⏰ Waktu habis, dikirim otomatis.' : '✅ Tes dikirim!');
                if (onSubmitSuccess) onSubmitSuccess();
            },
            onFinish: () => setSubmitting(false),
        });
    };

    return (
        <div className="rounded-2xl bg-white p-8 shadow-lg">
            <div className="mb-6 flex justify-between items-center">
                <h2 className="text-2xl font-bold text-gray-800">
                    Tes Akhir: {finalTest.title}
                </h2>
                <div className="text-lg font-semibold text-red-600">
                    ⏱ {formatTime(timeLeft)}
                </div>
            </div>

            <div className="space-y-8">
                {finalTest.questions.map((q, idx) => (
                    <div key={q.id} className="rounded-xl border border-gray-200 p-6 shadow-sm">
                        <h3
                            className="mb-3 font-semibold text-gray-800"
                            dangerouslySetInnerHTML={{
                                __html: `${idx + 1}. ${q.question}`,
                            }}
                        ></h3>

                        <textarea
                            className="w-full rounded-lg border p-3 text-gray-700 focus:ring-2 focus:ring-blue-500"
                            rows={4}
                            placeholder="Tulis jawabanmu di sini..."
                            value={answers[q.id]?.answer_text || ''}
                            onChange={(e) => handleTextChange(q.id, e.target.value)}
                        />

                        <div className="mt-3 flex items-center gap-3">
                            <input
                                type="file"
                                onChange={(e) => {
                                    if (e.target.files?.[0]) handleFileChange(q.id, e.target.files[0]);
                                }}
                            />
                            {answers[q.id]?.answer_file && (
                                <a
                                    href={`/storage/${answers[q.id].answer_file}`}
                                    target="_blank"
                                    className="text-blue-600 underline"
                                >
                                    📎 Lihat File
                                </a>
                            )}
                        </div>

                        <button
                            onClick={() => handleSaveAnswer(q.id)}
                            className="mt-4 rounded-lg bg-gray-100 px-4 py-2 text-sm text-gray-800 hover:bg-gray-200"
                        >
                            💾 Simpan Jawaban
                        </button>
                    </div>
                ))}
            </div>

            <div className="mt-10 text-center">
                <button
                    onClick={() => handleSubmit(false)}
                    disabled={submitting || timeLeft <= 0}
                    className={`rounded-xl px-8 py-3 font-semibold text-white ${
                        submitting || timeLeft <= 0
                            ? 'cursor-not-allowed bg-gray-400'
                            : 'bg-green-600 hover:bg-green-700'
                    }`}
                >
                    {submitting ? 'Mengirim...' : 'Kirim Tes Akhir'}
                </button>
            </div>
        </div>
    );
};

export default FinalTest;
