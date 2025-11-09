import Navigation from '@/components/navigation';
import { Head, router, usePage } from '@inertiajs/react';
import React, { useEffect, useState } from 'react';
import toast, { Toaster } from 'react-hot-toast';

type Option = {
    id: string;
    text: string;
    is_correct?: boolean;
};

type Question = {
    id: string;
    question_number?: number;
    text: string;
    options: Option[];
};

type Test = {
    id: number;
    title: string;
    description?: string;
    started_at?: string;
    duration_minutes?: number;
    questions: Question[];
};

interface PageProps {
    [key: string]: any;
    test: Test;
    hasSubmitted?: boolean;
    flash?: {
        success?: string;
        error?: string;
    };
    errors?: Record<string, string>;
}

export default function Show() {
    const { test, hasSubmitted, flash, errors } = usePage<PageProps>().props;
    const [answers, setAnswers] = useState<Record<string, string>>({});
    const [timeLeft, setTimeLeft] = useState<number>(
        (test.duration_minutes ?? 80) * 60,
    );
    const [formSubmitted, setFormSubmitted] = useState(false);

    // Label A, B, C, D, dst
    const getOptionLabel = (index: number): string => {
        return String.fromCharCode(65 + index); // 65 = 'A' in ASCII
    };

    // Timer countdown
    useEffect(() => {
        if (hasSubmitted) return;
        if (timeLeft <= 0) {
            handleSubmit(); // auto submit if time runs out
            return;
        }
        const timer = setTimeout(() => setTimeLeft(timeLeft - 1), 1000);
        return () => clearTimeout(timer);
    }, [timeLeft]);

    const formatTime = (seconds: number) => {
        const m = Math.floor(seconds / 60);
        const s = seconds % 60;
        return `${m}:${s.toString().padStart(2, '0')}`;
    };

    // Pilih jawaban
    const handleSelect = (questionId: string, optionId: string) => {
        setAnswers((prev) => ({ ...prev, [questionId]: optionId }));

        const answered = Object.keys({
            ...answers,
            [questionId]: optionId,
        }).length;
        toast.success(`Progres: ${answered}/${test.questions.length} soal`, {
            duration: 1500,
            style: {
                background: '#2f6a62',
                color: '#fff',
            },
        });
    };

    // Submit
    const handleSubmit = (e?: React.FormEvent) => {
        e?.preventDefault();

        if (formSubmitted || hasSubmitted) return;
        setFormSubmitted(true);

        const formattedAnswers = Object.keys(answers).map((qId) => ({
            question_id: qId,
            selected_option_id: answers[qId],
        }));

        if (formattedAnswers.length < test.questions.length) {
            const proceed = confirm(
                `Kamu baru menjawab ${formattedAnswers.length}/${test.questions.length} soal.\nYakin mau kirim jawaban?`,
            );
            if (!proceed) {
                setFormSubmitted(false);
                return;
            }
        }
        router.post(
            `/tka/submit`,
            { answers: formattedAnswers },
        );
    };

    // Warn before leaving
    useEffect(() => {
        const handleBeforeUnload = (e: BeforeUnloadEvent) => {
            if (!formSubmitted && !hasSubmitted) {
                e.preventDefault();
                e.returnValue = '';
            }
        };
        window.addEventListener('beforeunload', handleBeforeUnload);
        return () =>
            window.removeEventListener('beforeunload', handleBeforeUnload);
    }, [formSubmitted, hasSubmitted]);

    // Flash messages
    useEffect(() => {
        if (flash?.success) toast.success(flash.success);
        if (flash?.error || errors?.msg) toast.error(flash.error || errors.msg);
    }, [flash, errors]);

    return (
        <>
            <Head title={test.title} />
            <Toaster position="top-center" />
            <Navigation />

            <main className="min-h-screen bg-gradient-to-br from-[#e0eae8] to-[#f8faf9] px-4 py-10 style={{ fontFamily: 'Poppins, sans-serif' }}">
                <div className="mx-auto max-w-[1000px]">
                    {/* Header */}
                    <div className="animate-fade-in mb-8 text-center">
                        <h1 className="mb-2 text-3xl font-bold text-gray-900">
                            {test.title}
                        </h1>
                        <div className="mx-auto mb-3 h-1 w-24 bg-gradient-to-r from-transparent via-[#2f6a62] to-transparent"></div>
                        <p className="text-gray-600">
                            Total Soal:{' '}
                            <span className="font-bold text-[#2f6a62]">
                                {test.questions.length}
                            </span>
                        </p>
                    </div>

                    {/* Timer */}
                    {!hasSubmitted && (
                        <div className="timer-card mb-8 flex items-center justify-between rounded-xl border-2 border-[#2f6a62] bg-gradient-to-r from-[#2f6a62] to-[#3d8278] p-4 text-white shadow-lg">
                            <div className="flex items-center gap-3">
                                <div className="flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                    <svg
                                        className="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                </div>
                                <span className="font-semibold">
                                    Sisa Waktu:
                                </span>
                            </div>
                            <span className="text-lg font-bold">
                                {formatTime(timeLeft)}
                            </span>
                        </div>
                    )}

                    {/* Question List */}
                    <form onSubmit={handleSubmit} className="space-y-6">
                        {test.questions.map((q, index) => (
                            <div
                                key={q.id}
                                className="question-card rounded-xl border border-[#e0eae8] bg-white p-6 shadow-md transition-all duration-300"
                            >
                                <div className="mb-5 flex items-start gap-4">
                                    <span className="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#2f6a62] to-[#3d8278] text-sm font-bold text-white shadow-lg">
                                        {q.question_number ?? index + 1}
                                    </span>
                                    <p className="leading-relaxed font-medium text-gray-900">
                                        {q.text}
                                    </p>
                                </div>

                                <div className="ml-14 space-y-3">
                                    {q.options.map((opt, i) => (
                                        <div className="relative" key={opt.id}>
                                            <input
                                                type="radio"
                                                name={q.id}
                                                id={`q${q.id}_${opt.id}`}
                                                value={opt.id}
                                                checked={
                                                    answers[q.id] === opt.id
                                                }
                                                onChange={() =>
                                                    handleSelect(q.id, opt.id)
                                                }
                                                className="peer sr-only"
                                                required
                                            />
                                            <label
                                                htmlFor={`q${q.id}_${opt.id}`}
                                                className={`option-label flex items-start gap-3 rounded-lg border-2 p-4 cursor-pointer ${
                                                    answers[q.id] === opt.id
                                                        ? 'border-[#2f6a62] bg-gradient-to-br from-[#2f6a62] to-[#3d8278] text-white'
                                                        : 'border-[#e0eae8] bg-white text-gray-700 hover:bg-[#e0eae8]'
                                                } transition-all`}
                                            >
                                                <span
                                                    className={`option-circle flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full text-sm font-bold ${
                                                        answers[q.id] === opt.id
                                                            ? 'bg-white text-[#2f6a62]'
                                                            : 'bg-[#e0eae8] text-gray-800'
                                                    }`}
                                                >
                                                    {getOptionLabel(i)}
                                                </span>
                                                <span className="flex-1">
                                                    {opt.text}
                                                </span>
                                            </label>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        ))}

                        {/* Submit Button */}
                        {!hasSubmitted && (
                            <div className="mt-8 flex justify-center">
                                <button
                                    type="submit"
                                    className="btn-submit flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2f6a62] to-[#3d8278] px-10 py-4 font-semibold text-white shadow-lg transition-all hover:from-[#254d47] hover:to-[#2f6a62]"
                                >
                                    <svg
                                        className="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                                        ></path>
                                    </svg>
                                    Kumpulkan Jawaban
                                </button>
                            </div>
                        )}
                    </form>
                </div>
            </main>
        </>
    );
}