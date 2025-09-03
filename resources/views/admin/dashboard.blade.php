@extends('layout.admin')

@section('css')
<style>
    .bg-cocec-red {
        background-color: #EC281C !important;
    }

    .bg-cocec-yellow {
        background-color: #FFCC00 !important;
    }

    /* Styles pour les graphiques */
    .chart-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }

    .chart-container:hover {
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    }

    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
    }

    .chart-selector {
        margin-bottom: 15px;
    }

    .chart-selector select {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
    }
</style>
@endsection

@section('content')

@include('includes.admin.sidebar')
<main class="dashboard-main">
    @include('includes.admin.appbar')
    @include('includes.main.loading')

    <div class="dashboard-main-body">

        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Dashboard</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li></li>
                <li class="fw-medium"></li>
            </ul>
        </div>

        <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">
            <!-- Total des visiteurs -->
            <div class="col">
                <div class="card shadow-none border h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1">Visiteurs totaux</p>
                                <h6 class="mb-0">{{ number_format($totalVisitors) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cocec-red rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="ph:users-three-fill" class="text-white text-2xl"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abonnés à la newsletter -->
            <div class="col">
                <div class="card shadow-none border h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1">Abonnés newsletter</p>
                                <h6 class="mb-0">{{ number_format($totalSubscribers) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cocec-yellow rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:email-newsletter" class="text-white text-2xl"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Offres d'emploi -->
            <div class="col">
                <div class="card shadow-none border h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1">Offres d'emploi</p>
                                <h6 class="mb-0">{{ number_format($jobOffers) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cocec-red rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fa-solid:briefcase" class="text-white text-2xl"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Candidatures -->
            <div class="col">
                <div class="card shadow-none border h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1">Candidatures</p>
                                <h6 class="mb-0">{{ number_format($jobApplications) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cocec-yellow rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="fluent:people-queue-24-filled" class="text-white text-2xl"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Plaintes en attente -->
            <div class="col">
                <div class="card shadow-none border h-100">
                    <div class="card-body p-20">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="fw-medium text-muted mb-1">Plaintes en attente</p>
                                <h6 class="mb-0">{{ number_format($pendingComplaints ?? 0) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="mdi:cellphone-banking" class="text-white text-2xl"></iconify-icon>
                            </div>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.complaint.index') }}" class="text-decoration-none small text-muted">
                                Voir toutes les plaintes →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br><br>

        <!-- Graphiques -->
        <div class="row mt-4">
            <!-- Graphique des visiteurs -->
            <div class="col-12">
                <div class="chart-container">
                    <div class="chart-title">Visiteurs par période</div>
                    <div class="chart-selector">
                        <select id="visitorsChartSelector">
                            <option value="month">Par mois</option>
                            <option value="week">Par semaine</option>
                            <option value="day">Par jour</option>
                        </select>
                    </div>
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>
            {{-- <!-- Graphique des abonnés newsletter -->
            <div class="col-12">
                <div class="chart-container">
                    <div class="chart-title">Abonnés newsletter par mois</div>
                    <canvas id="subscribersChart"></canvas>
                </div>
            </div> --}}
        </div>

        @include('includes.admin.footer')
    </div>
</main>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données pour les graphiques
    const visitorsByMonth = @json($visitorsByMonth);
    const visitorsByDay = @json($visitorsByDay);
    const visitorsByWeek = @json($visitorsByWeek);
    // const subscribersByMonth = @json($subscribersByMonth);

    // Créer un dégradé pour le graphique des visiteurs
    function createGradient(ctx, chartArea, colorStart, colorEnd) {
        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }

    // Graphique des visiteurs
    let visitorsChartInstance;
    const visitorsCtx = document.getElementById('visitorsChart').getContext('2d');

    function updateVisitorsChart(period) {
        if (visitorsChartInstance) {
            visitorsChartInstance.destroy();
        }

        let labels, data, labelText;
        if (period === 'month') {
            labels = Object.keys(visitorsByMonth);
            data = Object.values(visitorsByMonth);
            labelText = 'Visiteurs par mois';
        } else if (period === 'week') {
            labels = Object.keys(visitorsByWeek);
            data = Object.values(visitorsByWeek);
            labelText = 'Visiteurs par semaine';
        } else {
            labels = Object.keys(visitorsByDay);
            data = Object.values(visitorsByDay);
            labelText = 'Visiteurs par jour';
        }

        visitorsChartInstance = new Chart(visitorsCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: labelText,
                    data: data,
                    borderColor: '#EC281C',
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const {
                            ctx,
                            chartArea
                        } = chart;
                        if (!chartArea) return;
                        return createGradient(ctx, chartArea, 'rgba(236, 40, 28, 0.2)', 'rgba(236, 40, 28, 0.8)');
                    },
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: '500'
                            },
                            color: '#333'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 12
                        },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.parsed.y} visiteurs`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre de visiteurs',
                            font: {
                                size: 14
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: period === 'month' ? 'Mois' : period === 'week' ? 'Semaine' : 'Jour',
                            font: {
                                size: 14
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    // Initialiser le graphique des visiteurs avec la période "mois"
    updateVisitorsChart('month');

    // Gestion du sélecteur de période
    document.getElementById('visitorsChartSelector').addEventListener('change', function() {
        updateVisitorsChart(this.value);
    });

    // Graphique des abonnés newsletter
    const subscribersCtx = document.getElementById('subscribersChart').getContext('2d');
    new Chart(subscribersCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(subscribersByMonth),
            datasets: [{
                label: 'Abonnés par mois',
                data: Object.values(subscribersByMonth),
                backgroundColor: (context) => {
                    const chart = context.chart;
                    const {
                        ctx,
                        chartArea
                    } = chart;
                    if (!chartArea) return;
                    return createGradient(ctx, chartArea, 'rgba(255, 204, 0, 0.5)', 'rgba(255, 204, 0, 0.9)');
                },
                borderColor: '#FFCC00',
                borderWidth: 1,
                borderRadius: 8,
                barThickness: 'flex',
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: {
                            size: 14,
                            weight: '500'
                        },
                        color: '#333'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleFont: {
                        size: 14
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: ${context.parsed.y} abonnés`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre d\'abonnés',
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Mois',
                        font: {
                            size: 14
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeOutQuart'
            }
        }
    });
</script>
@endsection