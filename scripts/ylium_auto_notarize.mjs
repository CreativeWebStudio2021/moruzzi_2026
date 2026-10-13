import { ethers } from 'ethers';

function argValue(name) {
  const idx = process.argv.indexOf(`--${name}`);
  if (idx === -1) return null;
  return process.argv[idx + 1] ?? null;
}

const rpc = argValue('rpc');
const privateKey = argValue('privateKey');
const contractAddress = argValue('contract');
const hash = argValue('hash'); // 0x...
const pdata0 = argValue('pdata0'); // 0x...
const noteB64 = argValue('noteB64') ?? '';
const delegee = argValue('delegee') ?? '';

if (!rpc || !privateKey || !contractAddress || !hash || !pdata0) {
  console.error(
    JSON.stringify({
      error:
        'Missing required args: --rpc --privateKey --contract --hash --pdata0 [--noteB64] [--delegee]',
    }),
  );
  process.exit(2);
}

const provider = new ethers.JsonRpcProvider(rpc);
const wallet = new ethers.Wallet(privateKey, provider);

const abi = [
  'function announce(bytes32 hash, bytes32 pdata0, string note)',
  'function announce(bytes32 hash, bytes32 pdata0, string note, address delegee)',
];

const contract = new ethers.Contract(contractAddress, abi, wallet);

function normalizeBytes32(x) {
  const s = String(x).toLowerCase().startsWith('0x') ? String(x) : `0x${x}`;
  if (s.length !== 66) throw new Error(`Invalid bytes32 length: ${s}`);
  return s;
}

const hashBytes32 = normalizeBytes32(hash);
const pdata0Bytes32 = normalizeBytes32(pdata0);
const note = Buffer.from(String(noteB64), 'base64').toString('utf8');

async function run() {
  // Proviamo prima la variante senza delegee; se fallisce e delegee è valorizzato
  // proviamo la variante con delegee.
  let tx;
  try {
    tx = await contract
      .getFunction('announce(bytes32,bytes32,string)')(hashBytes32, pdata0Bytes32, note);
  } catch (e) {
    if (delegee && delegee.startsWith('0x')) {
      tx = await contract
        .getFunction('announce(bytes32,bytes32,string,address)')(
          hashBytes32,
          pdata0Bytes32,
          note,
          delegee,
        );
    } else {
      throw e;
    }
  }

  // Wait for first confirmation
  const receipt = await tx.wait(1);
  console.log(JSON.stringify({ txHash: receipt.hash }));
}

run().catch((e) => {
  const message = e?.shortMessage || e?.message || String(e);
  console.error(JSON.stringify({ error: message }));
  process.exit(1);
});

