<template>
    <div
        class="tooltip"
        @mouseenter="showTooltip = true"
        @mouseleave="showTooltip = false"
    >
        <slot></slot>
        <div v-if="showTooltip" class="tooltip-content" :class="tooltipClasses">
            {{ tooltipText }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            showTooltip: false,
        };
    },
    props: {
        tooltipText: {
            type: String,
            required: true,
        },
        placement: {
            type: String,
            default: "bottom",
        },
    },
    computed: {
        tooltipClasses() {
            return {
                tooltip: true,
                invisible: !this.showTooltip,
                "inline-block": true,
                absolute: true,
                "z-10": true,
                "opacity-0": !this.showTooltip,
                "tooltip-bottom": this.placement === "bottom",
                // Add other placement classes for different tooltip positions
            };
        },
    },
};
</script>

<style scoped>
.tooltip {
    position: relative;
    display: inline-block;
}

.tooltip-content {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: #333;
    color: #fff;
    padding: 5px;
    border-radius: 3px;
    font-size: 12px;
    white-space: nowrap;
}

.tooltip-bottom {
    top: auto;
    bottom: calc(100% + 5px);
}
</style>
