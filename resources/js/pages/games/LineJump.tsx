import React, { useEffect, useRef, useState } from 'react';

interface Instruction {
    step: number;
    value: number;
    description: string;
    from: number;
    to: number;
}

const INSTRUCTIONS: Instruction[] = [
    {
        step: 1,
        value: 6,
        description: 'Pindah ke posisi -4',
        from: -10,
        to: -4,
    },
    { step: 2, value: 3, description: 'Pindah ke posisi -1', from: -4, to: -1 },
    { step: 3, value: 5, description: 'Pindah ke posisi 4', from: -1, to: 4 },
    { step: 4, value: -2, description: 'Pindah ke posisi 2', from: 4, to: 2 },
    { step: 5, value: 4, description: 'Pindah ke posisi 6', from: 2, to: 6 },
    { step: 6, value: -1, description: 'Pindah ke posisi 5', from: 6, to: 5 },
    { step: 7, value: 3, description: 'Pindah ke posisi 8', from: 5, to: 8 },
    { step: 8, value: 2, description: 'Pindah ke posisi 10', from: 8, to: 10 },
];

const LineJumpGame: React.FC = () => {
    const [currentStep, setCurrentStep] = useState(0);
    const [playerPosition, setPlayerPosition] = useState(-10);
    const [correctCount, setCorrectCount] = useState(0);
    const [timer, setTimer] = useState(20);
    const [showModal, setShowModal] = useState(false);
    const [isWaitingForMove, setIsWaitingForMove] = useState(false);
    const [moveOptions, setMoveOptions] = useState<number[]>([]);
    const [playerLeftPx, setPlayerLeftPx] = useState<number>(0);

    const timerRef = useRef<number | null>(null);
    const scrollContainerRef = useRef<HTMLDivElement | null>(null); // overflow-x-auto wrapper
    const innerLineRef = useRef<HTMLDivElement | null>(null); // min-w inner flex container

    // Generate opsi sekali per langkah
    const generateMoveOptions = (correctValue: number) => {
        const options = new Set<number>([correctValue]);
        const possibleValues = [-5, -4, -3, -2, -1, 0, 1, 2, 3, 4, 5, 6, 7, 8];
        while (options.size < 10) {
            const rand =
                possibleValues[
                    Math.floor(Math.random() * possibleValues.length)
                ];
            options.add(rand);
        }
        return Array.from(options).sort(() => Math.random() - 0.5);
    };

    // Timer effect
    useEffect(() => {
        if (isWaitingForMove) {
            timerRef.current = window.setInterval(() => {
                setTimer((prev) => {
                    if (prev <= 1) {
                        if (timerRef.current) clearInterval(timerRef.current);
                        handleMove(0); // auto move if timeout
                        return 0;
                    }
                    return prev - 1;
                });
            }, 1000);
        }
        return () => {
            if (timerRef.current) clearInterval(timerRef.current);
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [isWaitingForMove]);

    // Start game
    const startGame = () => {
        setCurrentStep(0);
        setCorrectCount(0);
        setPlayerPosition(-10);
        setIsWaitingForMove(true);
        setTimer(20);
        setMoveOptions(generateMoveOptions(INSTRUCTIONS[0].value));
        setShowModal(false);

        // Wait a tick, lalu hitung posisi awal
        setTimeout(() => {
            computePlayerLeftForPosition(-10);
        }, 0);
    };

    // Handle move
    const handleMove = (steps: number) => {
        if (!isWaitingForMove) return;
        if (timerRef.current) clearInterval(timerRef.current);
        setIsWaitingForMove(false);

        const instruction = INSTRUCTIONS[currentStep];
        const realSteps = steps === 0 ? instruction.value : steps;

        const nextPosition = playerPosition + realSteps;
        setPlayerPosition(nextPosition);

        const isCorrect =
            realSteps === instruction.value && nextPosition === instruction.to;
        if (isCorrect) setCorrectCount((c) => c + 1);

        // Pastikan DOM update → baru scroll
        requestAnimationFrame(() => {
            computePlayerLeftForPosition(nextPosition);

            requestAnimationFrame(() => {
                autoScrollToPlayer();
            });
        });

        // lanjut step berikutnya
        setTimeout(() => {
            if (currentStep + 1 >= INSTRUCTIONS.length) {
                setShowModal(true);
            } else {
                const nextStep = currentStep + 1;
                setCurrentStep(nextStep);
                setMoveOptions(
                    generateMoveOptions(INSTRUCTIONS[nextStep].value),
                );
                setTimer(20);
                setIsWaitingForMove(true);
            }
        }, 500);
    };

    // Render number line
    const renderNumberLine = () => {
        const points = [];
        for (let i = -10; i <= 10; i++) {
            points.push(
                <div
                    key={i}
                    // data-point attribute so we can measure it later
                    data-point={i}
                    className="relative flex min-w-[2.5rem] flex-col items-center justify-start"
                >
                    <div
                        className={`mb-2 h-3 w-3 rounded-full border-2 border-green-800 ${
                            i === INSTRUCTIONS[currentStep]?.to
                                ? 'animate-pulse bg-yellow-400 shadow-lg'
                                : 'bg-white'
                        }`}
                    />
                    <div
                        className={`font-bold ${i === 0 ? 'text-lg text-green-800' : 'text-gray-700'}`}
                    >
                        {i}
                    </div>
                </div>,
            );
        }
        return points;
    };

    // compute center-left px for a given position (number -10..10)
    const computePlayerLeftForPosition = (position: number) => {
        const index = position + 10; // -10 -> 0, 0 -> 10, 10 -> 20
        const container = innerLineRef.current;
        if (!container) return;

        const points = Array.from(
            container.querySelectorAll<HTMLElement>('[data-point]'),
        );
        const target = points[index];
        if (!target) return;

        // target center relative to innerLineRef
        const containerRect = container.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();

        const centerX =
            targetRect.left - containerRect.left + targetRect.width / 2;

        setPlayerLeftPx(centerX);
    };

    // Recompute on resize & scroll (so position stays aligned)
    useEffect(() => {
        const onResize = () => {
            computePlayerLeftForPosition(playerPosition);
        };
        const onScroll = () => {
            computePlayerLeftForPosition(playerPosition);
        };

        window.addEventListener('resize', onResize);

        const scrollContainer = scrollContainerRef.current;
        if (scrollContainer) {
            scrollContainer.addEventListener('scroll', onScroll);
        }

        // initial compute after mount
        setTimeout(() => computePlayerLeftForPosition(playerPosition), 50);

        return () => {
            window.removeEventListener('resize', onResize);
            if (scrollContainer)
                scrollContainer.removeEventListener('scroll', onScroll);
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [playerPosition]);

    // Update playerLeft when playerPosition changes (safe-guard)
    useEffect(() => {
        computePlayerLeftForPosition(playerPosition);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [currentStep]);

    const autoScrollToPlayer = () => {
        const scrollContainer = scrollContainerRef.current;
        if (!scrollContainer) return;

        // posisi player dalam px relatif ke container
        const playerCenter = playerLeftPx;

        const containerWidth = scrollContainer.clientWidth;

        // scroll sehingga player berada di tengah container
        const targetScroll = playerCenter - containerWidth / 2;

        scrollContainer.scrollTo({
            left: targetScroll,
            behavior: 'smooth',
        });
    };

    return (
        <div className="mx-2 flex w-full max-w-4xl flex-col items-center rounded-2xl bg-white p-6 shadow-2xl">
            <h1 className="mb-1 text-center text-2xl font-bold text-green-800">
                Line Jump
            </h1>
            <p className="mb-4 text-center text-sm text-gray-600">
                Melompatlah maju atau mundur sesuai instruksi!
            </p>

            <div className="mb-4 flex w-full flex-wrap justify-around gap-2 rounded-xl bg-gray-100 p-3">
                <div className="min-w-[6rem] text-center">
                    <div className="mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Langkah
                    </div>
                    <div className="text-lg font-bold text-green-800">
                        {currentStep}/{INSTRUCTIONS.length}
                    </div>
                </div>
                <div className="min-w-[6rem] text-center">
                    <div className="mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Benar
                    </div>
                    <div className="text-lg font-bold text-green-800">
                        {correctCount}
                    </div>
                </div>
                <div className="min-w-[6rem] text-center">
                    <div className="mb-1 text-xs font-semibold text-gray-500 uppercase">
                        Posisi
                    </div>
                    <div className="text-lg font-bold text-green-800">
                        {playerPosition}
                    </div>
                </div>
            </div>

            {/* Number line */}
            <div
                ref={scrollContainerRef}
                className="relative mb-4 w-full overflow-x-auto rounded-xl bg-gray-50 px-4 pt-10"
            >
                <div
                    ref={innerLineRef}
                    className="relative flex h-24 min-w-[600px] items-center"
                >
                    {renderNumberLine()}

                    {/* Player icon placed using absolute px (playerLeftPx) */}
                    <div
                        className="absolute mt-8 flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-green-700 to-green-900 text-xl text-white shadow-lg transition-all duration-300 ease-in-out"
                        style={{
                            left: playerLeftPx ? `${playerLeftPx}px` : '0px',
                            transform: 'translateX(-50%) translateY(-150%)',
                            top: 0,
                        }}
                    >
                        🎯
                    </div>
                </div>
            </div>

            {/* Instruction box */}
            <div className="mb-4 w-full rounded-xl bg-green-800 p-4 text-center text-white shadow-md">
                {currentStep < INSTRUCTIONS.length ? (
                    <>
                        <div className="mb-1 text-sm font-semibold">
                            Langkah {currentStep + 1} dari {INSTRUCTIONS.length}
                        </div>
                        <div className="text-lg font-bold">
                            {INSTRUCTIONS[currentStep].description}
                        </div>
                        <div className="mt-2 text-2xl font-extrabold text-yellow-400">
                            {timer}
                        </div>
                    </>
                ) : (
                    <div className="text-lg font-bold">
                        Tekan "Mulai Permainan" untuk memulai
                    </div>
                )}
            </div>

            {/* Start button */}
            <div className="mb-4 flex w-full flex-wrap justify-center gap-2">
                {currentStep === 0 && (
                    <button
                        className="rounded-lg bg-gradient-to-br from-green-700 to-green-900 px-6 py-3 font-bold tracking-wider text-white uppercase transition hover:shadow-lg"
                        onClick={startGame}
                    >
                        Mulai Permainan
                    </button>
                )}
            </div>

            {/* Movement buttons */}
            <div className="grid w-full max-w-2xl grid-cols-5 gap-2">
                {isWaitingForMove &&
                    moveOptions.map((val) => (
                        <button
                            key={val + Math.random()}
                            className="rounded-lg border-2 border-green-800 bg-white py-3 font-bold text-green-800 transition-all hover:bg-green-800 hover:text-white"
                            onClick={() => handleMove(val)}
                            disabled={!isWaitingForMove}
                        >
                            {val >= 0 ? `+${val}` : val}
                        </button>
                    ))}
            </div>

            {/* Modal */}
            {showModal && (
                <div className="bg-opacity-80 fixed inset-0 z-50 flex items-center justify-center bg-black">
                    <div className="animate-slide-in w-full max-w-md rounded-3xl bg-white p-8 text-center shadow-2xl">
                        <div className="mb-4 text-3xl font-bold text-green-800">
                            🎉 Permainan Selesai!
                        </div>
                        <div className="mb-2 text-xl text-gray-800">
                            Instruksi Benar: <strong>{correctCount}</strong>{' '}
                            dari {INSTRUCTIONS.length}
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

export default LineJumpGame;
