<style>
    .order-timeline-container {
        margin: 40px 0 50px;
        padding: 20px 0;
        position: relative;
    }
    .timeline-track {
        position: absolute;
        top: 25px;
        left: 5%;
        right: 5%;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
    }
    .timeline-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: var(--accent);
        transition: width 1s ease-in-out;
    }
    .timeline-steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }
    .timeline-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100px;
        text-align: center;
    }
    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #9ca3af;
        transition: all 0.3s ease;
        margin-bottom: 12px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    .timeline-step.active .step-icon {
        border-color: var(--accent);
        color: var(--accent);
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
    }
    .timeline-step.completed .step-icon {
        background: var(--accent);
        border-color: var(--accent);
        color: #fff;
    }
    .step-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
        color: #6b7280;
    }
    .timeline-step.active .step-label,
    .timeline-step.completed .step-label {
        color: #111;
    }

    @media (max-width: 640px) {
        .timeline-track { left: 25px; top: 0; bottom: 0; width: 2px; height: auto; right: auto; }
        .timeline-steps { flex-direction: column; gap: 40px; align-items: flex-start; padding-left: 0; }
        .timeline-step { flex-direction: row; width: auto; text-align: left; gap: 20px; }
        .step-icon { margin-bottom: 0; }
    }
</style>

@php
    $statusMap = [
        'pending' => 1,
        'processing' => 2,
        'shipped' => 3,
        'delivered' => 4,
        'completed' => 5
    ];
    $currentStep = $statusMap[strtolower($order->status)] ?? 1;
    if (strtolower($order->status) == 'cancelled' || strtolower($order->status) == 'refunded') $currentStep = 0;
    
    // Progress bar width: 0% for step 1, 33% for step 2, 66% for step 3, 100% for step 4 and beyond
    $progressWidth = $currentStep > 0 ? min(100, (($currentStep - 1) / 3) * 100) : 0;
@endphp

<div class="order-timeline-container">
    <div class="timeline-track">
        <div class="timeline-progress" style="width: {{ $progressWidth }}%"></div>
    </div>
    <div class="timeline-steps">
        <div class="timeline-step {{ $currentStep >= 1 ? ($currentStep > 1 ? 'completed' : 'active') : '' }}">
            <div class="step-icon"><i class="ri-shopping-bag-line"></i></div>
            <div class="step-label">Order Placed</div>
        </div>
        <div class="timeline-step {{ $currentStep >= 2 ? ($currentStep > 2 ? 'completed' : 'active') : '' }}">
            <div class="step-icon"><i class="ri-settings-3-line"></i></div>
            <div class="step-label">Processing</div>
        </div>
        <div class="timeline-step {{ $currentStep >= 3 ? ($currentStep > 3 ? 'completed' : 'active') : '' }}">
            <div class="step-icon"><i class="ri-truck-line"></i></div>
            <div class="step-label">Shipped</div>
        </div>
        <div class="timeline-step {{ $currentStep >= 4 ? ($currentStep > 4 ? 'completed' : 'active') : '' }}">
            <div class="step-icon"><i class="ri-checkbox-circle-line"></i></div>
            <div class="step-label">Delivered</div>
        </div>
    </div>
</div>
