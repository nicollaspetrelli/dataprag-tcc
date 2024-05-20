import { hookstate  } from '@hookstate/core';

const globalState = hookstate({
    isToPrintPayment: false,
});

export default globalState
